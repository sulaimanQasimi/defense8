#!/usr/bin/env python

import sys
import os
import struct
import math
import argparse

def extract_minutiae(iso_template_file):
    """
    Extract minutiae data from an ISO/IEC 19794-2 fingerprint template file
    """
    try:
        with open(iso_template_file, 'rb') as f:
            data = f.read()

        # Check for valid ISO template
        if len(data) < 30:
            sys.stderr.write(f"Invalid template, length is {len(data)}\n")
            return []

        # Parse header and get number of minutiae
        try:
            num_minutiae = struct.unpack('>H', data[28:30])[0]
            sys.stderr.write(f"Found {num_minutiae} minutiae in template\n")
        except Exception as e:
            sys.stderr.write(f"Error unpacking minutiae count: {str(e)}\n")
            return []

        minutiae = []
        offset = 30

        # Extract each minutia
        for i in range(num_minutiae):
            if offset + 6 <= len(data):
                try:
                    minutia_type = data[offset] & 0x0F
                    x = struct.unpack('>H', data[offset+1:offset+3])[0]
                    y = struct.unpack('>H', data[offset+3:offset+5])[0]
                    angle = data[offset+5]
                    quality = data[offset] >> 4

                    # Include all minutiae regardless of quality for better matching
                    minutiae.append({
                        'type': minutia_type,  # 1=ending, 2=bifurcation
                        'x': x,
                        'y': y,
                        'angle': angle,
                        'quality': quality
                    })
                except Exception as e:
                    sys.stderr.write(f"Error extracting minutia {i}: {str(e)}\n")

                offset += 6
            else:
                sys.stderr.write(f"Reached end of data at minutia {i}\n")
                break

        return minutiae
    except Exception as e:
        sys.stderr.write(f"Error extracting minutiae: {str(e)}\n")
        return []

def direct_binary_compare(template1, template2):
    """
    Directly compare binary data of two templates
    """
    try:
        with open(template1, 'rb') as f1, open(template2, 'rb') as f2:
            data1 = f1.read()
            data2 = f2.read()

        # Ensure templates are valid
        if len(data1) < 30 or len(data2) < 30:
            return 0

        # Get template format identifier
        format_id1 = data1[0:4]
        format_id2 = data2[0:4]

        # If format identifiers don't match, return 0
        if format_id1 != format_id2:
            return 0

        # Calculate similarity by comparing bytes
        similar_bytes = 0
        compare_length = min(len(data1), len(data2))

        # We focus on the minutiae data which starts at byte 30
        for i in range(30, compare_length):
            if data1[i] == data2[i]:
                similar_bytes += 1

        similarity = (similar_bytes / (compare_length - 30)) * 100 if compare_length > 30 else 0
        return int(similarity)
    except Exception as e:
        sys.stderr.write(f"Error in direct comparison: {str(e)}\n")
        return 0

def match_minutiae(template1, template2):
    """
    Match two sets of minutiae using improved matching algorithm
    Returns a match score between 0-100
    """
    # First try a direct binary comparison for exact matches
    direct_score = direct_binary_compare(template1, template2)
    if direct_score > 80:  # If templates are very similar
        return direct_score

    # Otherwise, fall back to minutiae-based matching
    minutiae1 = extract_minutiae(template1)
    minutiae2 = extract_minutiae(template2)

    if not minutiae1 or not minutiae2:
        return 0

    sys.stderr.write(f"Comparing {len(minutiae1)} minutiae with {len(minutiae2)} minutiae\n")

    # Calculate global translation parameters
    center_x1 = sum(m['x'] for m in minutiae1) / len(minutiae1)
    center_y1 = sum(m['y'] for m in minutiae1) / len(minutiae1)
    center_x2 = sum(m['x'] for m in minutiae2) / len(minutiae2)
    center_y2 = sum(m['y'] for m in minutiae2) / len(minutiae2)

    # Try different rotations to find the best match
    best_score = 0
    for rotation in range(0, 361, 10):  # Try rotations in 10-degree increments
        rotation_rad = math.radians(rotation)
        cos_theta = math.cos(rotation_rad)
        sin_theta = math.sin(rotation_rad)

        matched_count = 0
        total_possible = min(len(minutiae1), len(minutiae2))

        # Parameters for matching
        max_distance = 20  # Maximum distance between matched minutiae (increased from 15)
        angle_tolerance = 45  # Maximum angle difference (in 0-255 scale) (increased from 30)

        # For each minutia in first template, find closest match in second template
        for m1 in minutiae1:
            # Normalize coordinates relative to center
            rel_x1 = m1['x'] - center_x1
            rel_y1 = m1['y'] - center_y1

            # Apply rotation to find the best match
            rot_x = (rel_x1 * cos_theta) - (rel_y1 * sin_theta)
            rot_y = (rel_x1 * sin_theta) + (rel_y1 * cos_theta)

            # Transform back to absolute coordinates with second template's center
            abs_x = rot_x + center_x2
            abs_y = rot_y + center_y2

            # Find closest matching minutia in second template
            best_match_distance = float('inf')
            best_match = None

            for m2 in minutiae2:
                # Skip if minutiae types don't match (but only if both are high quality)
                if m1['quality'] >= 5 and m2['quality'] >= 5 and m1['type'] != m2['type']:
                    continue

                # Calculate Euclidean distance
                dx = abs_x - m2['x']
                dy = abs_y - m2['y']
                distance = math.sqrt(dx*dx + dy*dy)

                if distance < best_match_distance and distance <= max_distance:
                    best_match_distance = distance
                    best_match = m2

            # If we found a match within the distance threshold
            if best_match:
                # Calculate angle difference (0-255, where 255 is a full circle)
                angle_diff = min(abs(m1['angle'] - best_match['angle']),
                                255 - abs(m1['angle'] - best_match['angle']))

                # Check if angle is within tolerance or if quality is low (don't be strict on low quality minutiae)
                if angle_diff <= angle_tolerance or m1['quality'] < 3 or best_match['quality'] < 3:
                    matched_count += 1

        # Calculate score (percentage of matched minutiae)
        score = int((matched_count / total_possible) * 100) if total_possible > 0 else 0

        if score > best_score:
            best_score = score

    return best_score

def scan_directory_for_match(template_file, samples_dir, threshold=25):
    """
    Scan a directory of templates for a match
    Returns the filename of the best match if score is above threshold
    """
    best_match = None
    best_score = 0

    # Check if the template file exists
    if not os.path.exists(template_file):
        sys.stderr.write(f"Template file {template_file} does not exist\n")
        return None

    # Check if the directory exists
    if not os.path.exists(samples_dir) or not os.path.isdir(samples_dir):
        sys.stderr.write(f"Samples directory {samples_dir} does not exist\n")
        return None

    # Get all files in the directory
    for filename in os.listdir(samples_dir):
        sample_path = os.path.join(samples_dir, filename)

        # Skip directories
        if not os.path.isfile(sample_path):
            continue

        # Compare with the sample
        score = match_minutiae(template_file, sample_path)
        sys.stderr.write(f"Score for {filename}: {score}\n")

        # Keep track of the best match
        if score > best_score:
            best_score = score
            best_match = filename

    # Return the best match if it's above the threshold
    if best_score >= threshold:
        sys.stderr.write(f"Best match: {best_match} with score {best_score}\n")
        return best_match
    else:
        sys.stderr.write(f"No match found above threshold {threshold}. Best score was {best_score}\n")
        return None

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description='Match fingerprint templates')
    parser.add_argument('--samples', required=True, help='Directory containing sample templates')
    parser.add_argument('--fingerprint', required=True, help='Path to the fingerprint to match')
    parser.add_argument('--threshold', type=int, default=25, help='Matching threshold (default: 25)')

    args = parser.parse_args()

    match = scan_directory_for_match(args.fingerprint, args.samples, args.threshold)

    if match:
        print(match)

    sys.exit(0 if match else 1)
