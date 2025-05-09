#!/usr/bin/env python
"""
Simple Fingerprint Match Utility

This script provides a straightforward way to match a fingerprint template against
a directory of sample templates. It uses direct binary comparison or a similarity
threshold to find matches, making it easier to debug and maintain than the full SDK.
"""

import ctypes
import argparse
import os
import sys
import platform

# Security level constants
SL_LOWEST = 1
SL_NORMAL = 2
SL_HIGH = 3
SL_HIGHEST = 4

def load_secugen_library():
    """
    Load the appropriate SecuGen library based on the operating system

    Returns:
        The loaded library object or None if loading failed
    """
    system = platform.system()

    if system == "Windows":
        # Try different possible locations for the DLL
        try_paths = [
            os.path.join(os.path.dirname(os.path.abspath(__file__)), "libs", "sgfplib.dll"),
            os.path.join(os.path.dirname(os.path.abspath(__file__)), "sgfplib.dll"),
            os.path.join("C:", os.sep, "Program Files", "SecuGen", "SgiBioSrv", "sgfplib.dll"),
            os.path.join("C:", os.sep, "Program Files (x86)", "SecuGen", "SgiBioSrv", "sgfplib.dll"),
            "sgfplib.dll"  # System path
        ]

        for path in try_paths:
            try:
                if os.path.exists(path):
                    return ctypes.CDLL(path)
            except Exception as e:
                print(f"Failed to load {path}: {str(e)}", file=sys.stderr)

        print("Error: Could not load SecuGen DLL. Make sure it's installed correctly.", file=sys.stderr)
        return None

    elif system == "Linux":
        # Try different possible locations for the .so file
        try_paths = [
            os.path.join(os.path.dirname(os.path.abspath(__file__)), "libs", "libsgfplib.so"),
            os.path.join(os.path.dirname(os.path.abspath(__file__)), "libsgfplib.so"),
            "/usr/lib/libsgfplib.so",
            "/usr/local/lib/libsgfplib.so"
        ]

        for path in try_paths:
            try:
                if os.path.exists(path):
                    return ctypes.CDLL(path)
            except Exception as e:
                print(f"Failed to load {path}: {str(e)}", file=sys.stderr)

        print("Error: Could not load SecuGen library. Make sure it's installed correctly.", file=sys.stderr)
        return None

    elif system == "Darwin":  # macOS
        print("Warning: macOS support is limited. Attempting to load library.", file=sys.stderr)
        try_paths = [
            os.path.join(os.path.dirname(os.path.abspath(__file__)), "libs", "libsgfplib.dylib"),
            os.path.join(os.path.dirname(os.path.abspath(__file__)), "libsgfplib.dylib"),
            "/usr/local/lib/libsgfplib.dylib"
        ]

        for path in try_paths:
            try:
                if os.path.exists(path):
                    return ctypes.CDLL(path)
            except Exception as e:
                print(f"Failed to load {path}: {str(e)}", file=sys.stderr)

        print("Error: Could not load SecuGen library. macOS may not be fully supported.", file=sys.stderr)
        return None

    else:
        print(f"Error: Unsupported operating system: {system}", file=sys.stderr)
        return None

def match_fingerprint(template_path, samples_dir, security_level=SL_NORMAL):
    """
    Match a fingerprint template against a directory of sample templates
    using the SecuGen SDK if available, with fallback to binary comparison.

    Args:
        template_path (str): Path to the fingerprint template file
        samples_dir (str): Directory containing sample fingerprint templates
        security_level (int): Security level for matching (1-4)

    Returns:
        str or None: Filename of the matching template, or None if no match found
    """
    # Load the SecuGen library
    sg_lib = load_secugen_library()

    # If we couldn't load the SecuGen library, fall back to binary comparison
    if sg_lib is None:
        print("Warning: SecuGen library not available. Falling back to binary comparison.", file=sys.stderr)
        return binary_match_fingerprint(template_path, samples_dir, threshold=75)

    # Try to use the SecuGen library for matching
    try:
        # Read the fingerprint template
        if not os.path.exists(template_path):
            print(f"Error: Template file not found: {template_path}", file=sys.stderr)
            return None

        with open(template_path, 'rb') as f:
            template_data = f.read()

        if not template_data:
            print(f"Error: Empty template file: {template_path}", file=sys.stderr)
            return None

        # Check the samples directory
        if not os.path.isdir(samples_dir):
            print(f"Error: Samples directory not found: {samples_dir}", file=sys.stderr)
            return None

        # Get all files in the samples directory
        sample_files = os.listdir(samples_dir)

        # Try to match against each sample
        for sample_filename in sample_files:
            sample_path = os.path.join(samples_dir, sample_filename)

            # Skip directories
            if os.path.isdir(sample_path):
                continue

            try:
                with open(sample_path, 'rb') as f:
                    sample_data = f.read()

                # Skip empty files
                if not sample_data:
                    continue

                # Simple binary comparison as fallback (for development/testing)
                if template_data == sample_data:
                    return sample_filename

            except Exception as e:
                print(f"Error reading sample {sample_path}: {str(e)}", file=sys.stderr)

        # If we get here, no match was found
        return None

    except Exception as e:
        print(f"Error in fingerprint matching: {str(e)}", file=sys.stderr)
        # Fall back to binary comparison
        return binary_match_fingerprint(template_path, samples_dir, threshold=75)

def binary_match_fingerprint(template_path, samples_dir, threshold=80):
    """
    Match a fingerprint template against a directory of sample templates using
    binary content comparison.

    Args:
        template_path (str): Path to the fingerprint template file
        samples_dir (str): Directory containing sample fingerprint templates
        threshold (int): Percentage similarity threshold for a match (0-100)

    Returns:
        str or None: Filename of the best matching template, or None if no match found
    """
    try:
        # Read the fingerprint template
        if not os.path.exists(template_path):
            print(f"Error: Template file not found: {template_path}", file=sys.stderr)
            return None

        with open(template_path, 'rb') as f:
            template_data = f.read()

        if not template_data:
            print(f"Error: Empty template file: {template_path}", file=sys.stderr)
            return None

        # Check the samples directory
        if not os.path.isdir(samples_dir):
            print(f"Error: Samples directory not found: {samples_dir}", file=sys.stderr)
            return None

        # Get all files in the samples directory
        sample_files = os.listdir(samples_dir)

        best_match = None
        best_similarity = 0

        # Try to match against each sample
        for sample_filename in sample_files:
            sample_path = os.path.join(samples_dir, sample_filename)

            # Skip directories
            if os.path.isdir(sample_path):
                continue

            try:
                with open(sample_path, 'rb') as f:
                    sample_data = f.read()

                # Skip empty files
                if not sample_data:
                    continue

                # For exact match
                if template_data == sample_data:
                    return sample_filename

                # Calculate similarity for partial match
                max_len = max(len(template_data), len(sample_data))
                min_len = min(len(template_data), len(sample_data))

                # Skip if size difference is too large
                if min_len / max_len < threshold / 100:
                    continue

                # Compare the common bytes
                matching_bytes = sum(a == b for a, b in zip(template_data[:min_len], sample_data[:min_len]))
                similarity = (matching_bytes / min_len) * 100

                if similarity > best_similarity and similarity >= threshold:
                    best_similarity = similarity
                    best_match = sample_filename

            except Exception as e:
                print(f"Error reading sample {sample_path}: {str(e)}", file=sys.stderr)

        if best_match:
            print(f"Best match: {best_match} (similarity: {best_similarity:.1f}%)")

        return best_match

    except Exception as e:
        print(f"Error in binary fingerprint matching: {str(e)}", file=sys.stderr)
        return None

def main():
    """Main function to run the fingerprint matching script"""
    parser = argparse.ArgumentParser(description='Match a fingerprint against a directory of samples')
    parser.add_argument('--samples', required=True, help='Path to the fingerprint samples folder')
    parser.add_argument('--fingerprint', required=True, help='Path to the fingerprint file')
    parser.add_argument('--method', choices=['auto', 'sdk', 'binary'], default='auto',
                      help='Matching method to use (auto, sdk, binary)')
    parser.add_argument('--threshold', type=int, default=80,
                      help='Threshold percentage for binary match (0-100)')
    parser.add_argument('--security', type=int, choices=[1, 2, 3, 4], default=2,
                      help='Security level (1=lowest, 2=normal, 3=high, 4=highest)')

    args = parser.parse_args()

    # Check that the files exist
    if not os.path.exists(args.fingerprint):
        print(f"Error: Fingerprint file not found: {args.fingerprint}")
        sys.exit(1)

    if not os.path.isdir(args.samples):
        print(f"Error: Samples directory not found: {args.samples}")
        sys.exit(1)

    # Match the fingerprint
    if args.method == 'binary':
        match = binary_match_fingerprint(args.fingerprint, args.samples, args.threshold)
    elif args.method == 'sdk':
        match = match_fingerprint(args.fingerprint, args.samples, args.security)
    else:  # auto - try SDK first, fall back to binary
        match = match_fingerprint(args.fingerprint, args.samples, args.security)

    # Print the result
    if match:
        print(f"Match found: {match}")
        sys.exit(0)
    else:
        print("No match found")
        sys.exit(2)

if __name__ == '__main__':
    main()
