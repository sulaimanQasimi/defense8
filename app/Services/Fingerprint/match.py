#!/usr/bin/env python

import sys
import os
import struct

def extract_minutiae(iso_template_file):
    """
    Extract minutiae data from an ISO/IEC 19794-2 fingerprint template file
    """
    try:
        with open(iso_template_file, 'rb') as f:
            data = f.read()

        # Check for valid ISO template
        if len(data) < 30:
            return []

        # Parse header and get number of minutiae
        num_minutiae = struct.unpack('>H', data[28:30])[0]

        minutiae = []
        offset = 30

        # Extract each minutia
        for i in range(num_minutiae):
            if offset + 6 <= len(data):
                minutia_type = data[offset] & 0x0F
                x = struct.unpack('>H', data[offset+1:offset+3])[0]
                y = struct.unpack('>H', data[offset+3:offset+5])[0]
                angle = data[offset+5]
                quality = data[offset] >> 4

                minutiae.append({
                    'type': minutia_type,  # 1=ending, 2=bifurcation
                    'x': x,
                    'y': y,
                    'angle': angle,
                    'quality': quality
                })

                offset += 6

        return minutiae
    except Exception as e:
        sys.stderr.write(f"Error extracting minutiae: {str(e)}\n")
        return []

def match_minutiae(template1, template2, max_distance=15, min_matched=8):
    """
    Match two sets of minutiae
    Returns true if they match, false otherwise
    """
    minutiae1 = extract_minutiae(template1)
    minutiae2 = extract_minutiae(template2)

    if not minutiae1 or not minutiae2:
        return False

    matched = 0

    for m1 in minutiae1:
        for m2 in minutiae2:
            # Skip if minutiae types don't match
            if m1['type'] != m2['type']:
                continue

            # Calculate Euclidean distance
            distance = ((m1['x'] - m2['x'])**2 + (m1['y'] - m2['y'])**2)**0.5

            # Calculate angle difference (0-255, where 255 is a full circle)
            angle_diff = min(abs(m1['angle'] - m2['angle']), 255 - abs(m1['angle'] - m2['angle']))
            angle_threshold = 30  # Allow about 42 degrees difference (255 * 60/360)

            if distance <= max_distance and angle_diff <= angle_threshold:
                matched += 1
                break

    return matched >= min_matched

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage: python match.py <template1_path> <template2_path>")
        sys.exit(1)

    template1 = sys.argv[1]
    template2 = sys.argv[2]

    if not os.path.exists(template1) or not os.path.exists(template2):
        print("0")
        sys.exit(1)

    result = match_minutiae(template1, template2)
    print("1" if result else "0")
    sys.exit(0)