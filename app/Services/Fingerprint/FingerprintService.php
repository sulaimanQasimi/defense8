<?php

namespace App\Services\Fingerprint;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Exception;

class FingerprintService
{
    /**
     * Match a fingerprint against samples
     *
     * @param string $samplesDir Directory containing fingerprint samples
     * @param string|UploadedFile $fingerprintToMatch Path to fingerprint file or uploaded file
     * @return string|null Filename of the matching sample or null if no match
     */
    public function match(string $samplesDir, $fingerprintToMatch)
    {
        try {
            $tempFile = null;

            // Handle uploaded file
            if ($fingerprintToMatch instanceof UploadedFile) {
                $tempFile = sys_get_temp_dir() . '/' . uniqid('fingerprint_');
                file_put_contents($tempFile, $fingerprintToMatch->get());
                $fingerprintToMatch = $tempFile;
            }

            // Convert IsoTemplate base64 string to temp file
            if (is_string($fingerprintToMatch) &&
                (strpos($fingerprintToMatch, 'data:') === 0 ||
                 base64_encode(base64_decode($fingerprintToMatch, true)) === $fingerprintToMatch)) {

                $tempFile = sys_get_temp_dir() . '/' . uniqid('fingerprint_base64_');
                $decodedData = base64_decode($fingerprintToMatch);

                // Check if the decoded data is valid
                if (empty($decodedData)) {
                    Log::error("Failed to decode base64 data. Input length: " . strlen($fingerprintToMatch));
                    throw new Exception("Invalid base64 data");
                }

                // Try to write decoded data to file
                if (file_put_contents($tempFile, $decodedData) === false) {
                    Log::error("Failed to write decoded template to file: " . $tempFile);
                    throw new Exception("Failed to write template data to file");
                }

                // Log decoded template info
                Log::debug("Decoded template size: " . strlen($decodedData) . " bytes, saved to: " . $tempFile);

                $fingerprintToMatch = $tempFile;
            } else if (is_string($fingerprintToMatch) && !file_exists($fingerprintToMatch)) {
                // If it's a string but not a base64 and not an existing file, it's an error
                Log::error("Invalid fingerprint data provided: not a file and not base64");
                throw new Exception("Invalid fingerprint data: not a file and not base64");
            }

            // Ensure sample directory exists
            if (!File::isDirectory($samplesDir)) {
                throw new Exception("Samples directory does not exist: {$samplesDir}");
            }

            // Get all fingerprint samples
            $samples = File::files($samplesDir);

            if (empty($samples)) {
                throw new Exception("No fingerprint samples found in {$samplesDir}");
            }

            // Run Python fingerprint matching script
            $pythonScript = __DIR__ . '/match.py';
            if (!File::exists($pythonScript)) {
                $this->createPythonMatchScript();
            }

            // Determine the Python command to use
            $pythonCommand = $this->getPythonCommand();
            if (!$pythonCommand) {
                throw new Exception("Python is not installed on this system");
            }

            // Log the fingerprint matching attempt
            Log::info("Attempting to match fingerprint against " . count($samples) . " samples using: " . $pythonCommand);

            // Define best match variables
            $bestMatchScore = 0;
            $bestMatchFile = null;
            $bestOutputLog = "";

            // Process all samples and find the best match
            foreach ($samples as $sample) {
                $samplePath = $sample->getPathname();
                $sampleFilename = $sample->getFilename();

                Log::debug("Comparing with sample: " . $sampleFilename);

                // Make sure both files exist and are readable
                if (!is_readable($fingerprintToMatch)) {
                    Log::warning("Template file is not readable: " . $fingerprintToMatch);
                    continue;
                }

                if (!is_readable($samplePath)) {
                    Log::warning("Sample file is not readable: " . $samplePath);
                    continue;
                }

                // Capture both stdout and stderr
                $command = $pythonCommand . " " . escapeshellarg($pythonScript) . " " .
                       escapeshellarg($fingerprintToMatch) . " " .
                       escapeshellarg($samplePath) . " 2>&1";

                $output = [];
                $returnCode = 0;
                exec($command, $output, $returnCode);

                $outputLog = implode("\n", $output);

                // Log the full command output for debugging
                Log::debug("Command output for $sampleFilename: " . $outputLog);

                if ($returnCode !== 0) {
                    Log::warning("Command failed with return code $returnCode for $sampleFilename");
                    continue;
                }

                // The last line should be the score
                $score = 0;
                if (!empty($output)) {
                    // Get the last line which should be the score
                    $lastLine = end($output);
                    if (is_numeric(trim($lastLine))) {
                        $score = (int)$lastLine;
                    } else {
                        Log::warning("Invalid score output for $sampleFilename: $lastLine");
                    }
                }

                Log::debug("Match score for " . $sampleFilename . ": " . $score);

                if ($score > $bestMatchScore) {
                    $bestMatchScore = $score;
                    $bestMatchFile = $sampleFilename;
                    $bestOutputLog = $outputLog;
                }
            }

            // Clean up temp file if created
            if ($tempFile && file_exists($tempFile)) {
                unlink($tempFile);
            }

            // A score of at least 25 is considered a match (further lowered threshold)
            if ($bestMatchScore >= 25) {
                Log::info("Fingerprint match found: " . $bestMatchFile . " with score " . $bestMatchScore);
                Log::debug("Best match output: " . $bestOutputLog);
                return $bestMatchFile;
            } else {
                Log::info("No fingerprint match found. Best score was " . $bestMatchScore);
                Log::debug("Best non-match output: " . $bestOutputLog);
                return null;
            }
        } catch (Exception $e) {
            Log::error("Fingerprint matching error: " . $e->getMessage() . "\n" . $e->getTraceAsString());

            // Clean up temp file if created
            if (isset($tempFile) && $tempFile && file_exists($tempFile)) {
                unlink($tempFile);
            }

            return null;
        }
    }

    /**
     * Matches a proprietary SecuGen template with a stored fingerprint.
     *
     * @param string $fingerprintToMatch Path to the template file
     * @param string $samplePath Path to the stored fingerprint
     * @return int Match score from 0-100
     */
    public function matchProprietary($fingerprintToMatch, $samplePath)
    {
        try {
            // Check if paths exist
            if (!file_exists($fingerprintToMatch) || !is_readable($fingerprintToMatch)) {
                Log::error("Can't read template at: $fingerprintToMatch");
                throw new Exception("Can't read template file");
            }

            if (!file_exists($samplePath) || !is_readable($samplePath)) {
                Log::error("Can't read sample at: $samplePath");
                throw new Exception("Can't read sample file");
            }

            // Log template sizes for debugging
            $templateSize = filesize($fingerprintToMatch);
            $sampleSize = filesize($samplePath);
            Log::debug("Template size: $templateSize bytes, Sample size: $sampleSize bytes");

            // First try a direct binary comparison
            if ($templateSize === $sampleSize) {
                $template1 = file_get_contents($fingerprintToMatch);
                $template2 = file_get_contents($samplePath);

                if ($template1 === $template2) {
                    Log::info("Exact binary match found between templates");
                    return 100; // Perfect match
                }

                // Calculate similarity for proprietary templates (byte comparison)
                $similarBytes = 0;
                for ($i = 0; $i < $templateSize; $i++) {
                    if ($template1[$i] === $template2[$i]) {
                        $similarBytes++;
                    }
                }

                $similarity = ($similarBytes / $templateSize) * 100;
                $score = (int)$similarity;

                if ($score >= 80) {
                    Log::info("High similarity binary match found between templates: $score%");
                    return $score;
                }
            }

            // If direct comparison fails, try using our Python script
            // Get the appropriate Python command
            $pythonCommand = $this->getPythonCommand();
            if (!$pythonCommand) {
                throw new Exception("Python is not installed on this system");
            }

            // Ensure our script exists
            $pythonScript = __DIR__ . '/match.py';
            if (!File::exists($pythonScript)) {
                $this->createPythonMatchScript();
            }

            // Run the matching script with both templates
            $command = $pythonCommand . " " . escapeshellarg($pythonScript) . " " .
                   escapeshellarg($fingerprintToMatch) . " " .
                   escapeshellarg($samplePath) . " 2>&1";

            $output = [];
            $returnCode = 0;
            exec($command, $output, $returnCode);

            $outputLog = implode("\n", $output);
            Log::debug("Command output: " . $outputLog);

            if ($returnCode !== 0) {
                Log::warning("Command failed with return code $returnCode");
                return 0;
            }

            // The last line should be the score
            $score = 0;
            if (!empty($output)) {
                // Get the last line which should be the score
                $lastLine = end($output);
                if (is_numeric(trim($lastLine))) {
                    $score = (int)$lastLine;
                } else {
                    Log::warning("Invalid score output: $lastLine");
                }
            }

            Log::info("Proprietary template match score: $score");
            return $score;
        } catch (Exception $e) {
            Log::error("Proprietary template matching error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get the appropriate Python command
     *
     * @return string|null The Python command to use, or null if Python is not available
     */
    private function getPythonCommand()
    {
        // Try 'python' command
        $output = [];
        $returnCode = 0;
        exec('python --version 2>&1', $output, $returnCode);

        if ($returnCode === 0) {
            return 'python';
        }

        // Try 'python3' command
        $output = [];
        $returnCode = 0;
        exec('python3 --version 2>&1', $output, $returnCode);

        if ($returnCode === 0) {
            return 'python3';
        }

        // Try 'py' command (Windows)
        $output = [];
        $returnCode = 0;
        exec('py --version 2>&1', $output, $returnCode);

        if ($returnCode === 0) {
            return 'py';
        }

        return null;
    }

    /**
     * Create the Python script for fingerprint matching
     */
    private function createPythonMatchScript()
    {
        $pythonCode = <<<'PYTHON'
#!/usr/bin/env python

import sys
import os
import struct
import math

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

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage: python match.py <template1_path> <template2_path>")
        sys.exit(1)

    template1 = sys.argv[1]
    template2 = sys.argv[2]

    if not os.path.exists(template1) or not os.path.exists(template2):
        print("0")
        sys.exit(1)

    score = match_minutiae(template1, template2)
    print(score)
    sys.exit(0)
PYTHON;

        file_put_contents(__DIR__ . '/match.py', $pythonCode);
    }
}
