<?php

namespace Sq\Fingerprint\Match;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Exception;

class MatchService
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
     * Determines which Python command to use on the system
     * 
     * @return string|null Python command or null if not found
     */
    private function getPythonCommand()
    {
        $possibleCommands = ['python3', 'python', 'py'];
        
        foreach ($possibleCommands as $cmd) {
            $testCmd = PHP_OS_FAMILY === 'Windows' ? 
                "where $cmd 2>nul" : 
                "which $cmd 2>/dev/null";
            
            $output = [];
            $returnCode = 0;
            exec($testCmd, $output, $returnCode);
            
            if ($returnCode === 0 && !empty($output)) {
                // Verify it can run a simple python command
                $version = [];
                exec("$cmd --version 2>&1", $version, $versionCode);
                
                if ($versionCode === 0) {
                    return $cmd;
                }
            }
        }
        
        return null;
    }

    /**
     * Creates a Python script for fingerprint matching
     */
    private function createPythonMatchScript()
    {
        $scriptPath = __DIR__ . '/match.py';
        $scriptContent = <<<'PYTHON'
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
PYTHON;

        File::put($scriptPath, $scriptContent);
        chmod($scriptPath, 0755); // Make executable

        return true;
    }
} 