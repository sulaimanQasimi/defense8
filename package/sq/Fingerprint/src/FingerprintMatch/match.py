#! /usr/bin/env python
"""
Fingerprint matching utility using SecuGen SDK

This script compares a fingerprint template against a folder of template samples
to find a match. It uses the SecuGen SDK and returns the matched filename
or exits with error code 1 if no match is found.
"""

from libs.pysgfplib import *
import argparse
import os
import sys

def match_fingerprint(template_path, samples_dir, security_level=SGFDxSecurityLevel.SL_NORMAL):
    """
    Match a fingerprint template against a directory of sample templates

    Args:
        template_path (str): Path to the fingerprint template file to match
        samples_dir (str): Directory containing sample fingerprint templates
        security_level: Security level for matching (default: SL_NORMAL)

    Returns:
        str: Filename of the matching template, or None if no match found
    """
    try:
        # Initialize SecuGen library
        sgfplib = PYSGFPLib()
        result = sgfplib.Create()
        if result != SGFDxErrorCode.SGFDX_ERROR_NONE:
            sys.stderr.write(f"Error creating SGFPLib: {result}\n")
            return None

        result = sgfplib.Init(0x4)
        if result != SGFDxErrorCode.SGFDX_ERROR_NONE:
            sys.stderr.write(f"Error initializing SGFPLib: {result}\n")
            return None

        # Read the template to match
        try:
            with open(template_path, 'rb') as file:
                compare1 = file.read()
        except Exception as e:
            sys.stderr.write(f"Error reading template file: {str(e)}\n")
            sgfplib.Terminate()
            return None

        # Loop through all files in the samples directory
        for filename in os.listdir(samples_dir):
            sample_path = os.path.join(samples_dir, filename)

            # Skip directories
            if not os.path.isfile(sample_path):
                continue

            try:
                # Read the sample template
                with open(sample_path, 'rb') as file:
                    compare2 = file.read()

                # Compare templates
                cMatched = c_bool(False)
                result = sgfplib.MatchTemplate(compare1, compare2, security_level, byref(cMatched))

                if result != SGFDxErrorCode.SGFDX_ERROR_NONE:
                    sys.stderr.write(f"Error matching templates: {result}\n")
                    continue

                # If match found, return the filename
                if cMatched.value == True:
                    sgfplib.Terminate()
                    return filename

            except Exception as e:
                sys.stderr.write(f"Error processing {filename}: {str(e)}\n")
                continue

        # Clean up and return None if no match found
        sgfplib.Terminate()
        return None

    except Exception as e:
        sys.stderr.write(f"Error in match_fingerprint: {str(e)}\n")
        return None

if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='Match a fingerprint template against samples')
    parser.add_argument('--samples', metavar='path', required=True,
                       help='Path to the directory containing fingerprint samples')
    parser.add_argument('--fingerprint', metavar='path', required=True,
                       help='Path to the fingerprint template file to match')
    parser.add_argument('--security', metavar='level', type=int, default=1,
                       help='Security level (0=lowest, 1=normal, 2=high, 3=highest)')
    args = parser.parse_args()

    # Convert numeric security level to SGFDxSecurityLevel enum
    security_level_map = {
        0: SGFDxSecurityLevel.SL_LOWEST,
        1: SGFDxSecurityLevel.SL_NORMAL,
        2: SGFDxSecurityLevel.SL_HIGH,
        3: SGFDxSecurityLevel.SL_HIGHEST
    }
    security_level = security_level_map.get(args.security, SGFDxSecurityLevel.SL_NORMAL)

    # Make sure the samples directory exists
    if not os.path.isdir(args.samples):
        sys.stderr.write(f"Error: Samples directory not found: {args.samples}\n")
        sys.exit(1)

    # Make sure the fingerprint file exists
    if not os.path.isfile(args.fingerprint):
        sys.stderr.write(f"Error: Fingerprint file not found: {args.fingerprint}\n")
        sys.exit(1)

    # Perform the matching
    match_result = match_fingerprint(args.fingerprint, args.samples, security_level)

    if match_result:
        # Output only the filename on success
        print(match_result)
        sys.exit(0)
    else:
        # No match found
        sys.exit(1)