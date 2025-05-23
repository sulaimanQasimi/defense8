<?php

namespace Sq\Employee\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Exception;

class FingerprintService
{
    /**
     * Match a fingerprint template against a database of fingerprint samples
     *
     * @param string $fingerprintTemplate Path to the fingerprint template file
     * @param string $samplesDir Directory containing fingerprint samples
     * @param int $securityLevel Security level for matching (1=lowest, 2=normal, 3=high, 4=highest)
     * @return string|null Filename of the matching sample or null if no match
     */
    public function match($fingerprintTemplate, $samplesDir, $securityLevel = 2)
    {
        try {
            if (!file_exists($fingerprintTemplate)) {
                throw new Exception("Fingerprint template file not found: {$fingerprintTemplate}");
            }

            if (!is_dir($samplesDir)) {
                throw new Exception("Samples directory not found: {$samplesDir}");
            }

            // First try the SDK-based match.py
            $sdkMatchResult = $this->matchUsingSDK($fingerprintTemplate, $samplesDir, $securityLevel);
            if ($sdkMatchResult !== null) {
                Log::info("Fingerprint matched using SDK: {$sdkMatchResult}");
                return $sdkMatchResult;
            }

            // If SDK match fails, try the simple_match.py
            $simpleMatchResult = $this->matchUsingSimple($fingerprintTemplate, $samplesDir);
            if ($simpleMatchResult !== null) {
                Log::info("Fingerprint matched using simple method: {$simpleMatchResult}");
                return $simpleMatchResult;
            }

            Log::info("No fingerprint match found using any method");
            return null;

        } catch (Exception $e) {
            Log::error("Error matching fingerprint: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Match fingerprint using the SDK-based match.py script
     *
     * @param string $fingerprintTemplate
     * @param string $samplesDir
     * @param int $securityLevel
     * @return string|null
     */
    protected function matchUsingSDK($fingerprintTemplate, $samplesDir, $securityLevel)
    {
        try {
            // Use the SecuGen matching script from our package
            $matchScript = dirname(__DIR__) . '/../../Fingerprint/src/FingerprintMatch/match.py';

            if (!file_exists($matchScript)) {
                Log::warning("SDK matching script not found: {$matchScript}");
                return null;
            }

            // Get the appropriate Python command
            $pythonCommand = $this->getPythonCommand();
            if (!$pythonCommand) {
                Log::warning("Python interpreter not found for SDK matching");
                return null;
            }

            // Create and execute the matching command
            $command = $pythonCommand . " " . escapeshellarg($matchScript) . " " .
                     "--samples=" . escapeshellarg($samplesDir) . " " .
                     "--fingerprint=" . escapeshellarg($fingerprintTemplate) . " " .
                     "--security=" . escapeshellarg($securityLevel) . " " .
                     "2>&1";

            Log::debug("Running SDK fingerprint match command: {$command}");

            exec($command, $output, $returnCode);

            $outputStr = implode(PHP_EOL, $output);
            Log::debug("SDK match command output: {$outputStr}, Return code: {$returnCode}");

            // If there was a match, it will be in the output
            if ($returnCode === 0 && !empty($output)) {
                $matchFile = trim($output[0]);
                return $matchFile;
            }

            // If there's an error, log it but don't return error to allow fallback
            if ($returnCode !== 1) {
                Log::warning("SDK match script returned unexpected code: {$returnCode}");
            }

            return null;
        } catch (Exception $e) {
            Log::warning("Error using SDK match script: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Match fingerprint using the simple_match.py script
     *
     * @param string $fingerprintTemplate
     * @param string $samplesDir
     * @return string|null
     */
    protected function matchUsingSimple($fingerprintTemplate, $samplesDir)
    {
        try {
            // Use the simple matching script
            $matchScript = dirname(__DIR__) . '/../../Fingerprint/src/FingerprintMatch/simple_match.py';

            if (!file_exists($matchScript)) {
                Log::warning("Simple matching script not found: {$matchScript}");
                return null;
            }

            // Get the appropriate Python command
            $pythonCommand = $this->getPythonCommand();
            if (!$pythonCommand) {
                Log::warning("Python interpreter not found for simple matching");
                return null;
            }

            // Create and execute the matching command
            $command = $pythonCommand . " " . escapeshellarg($matchScript) . " " .
                     "--samples=" . escapeshellarg($samplesDir) . " " .
                     "--fingerprint=" . escapeshellarg($fingerprintTemplate) . " " .
                     "--method=auto " .
                     "2>&1";

            Log::debug("Running simple fingerprint match command: {$command}");

            exec($command, $output, $returnCode);

            $outputStr = implode(PHP_EOL, $output);
            Log::debug("Simple match command output: {$outputStr}, Return code: {$returnCode}");

            // Parse the output for the match result
            // The simple_match.py script outputs "Match found: filename" on success
            if ($returnCode === 0 && !empty($output)) {
                foreach ($output as $line) {
                    if (preg_match('/Match found: (.+)/', $line, $matches)) {
                        return trim($matches[1]);
                    }
                }

                // If no match pattern found, but return code is 0,
                // use the last line of output as a fallback
                return trim(end($output));
            }

            return null;
        } catch (Exception $e) {
            Log::warning("Error using simple match script: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create fingerprint samples directory and save fingerprint templates
     *
     * @param array $bioDataRecords Collection of BioData records
     * @param string $directory Directory to store fingerprint samples
     * @return string Path to the samples directory or null on failure
     */
    public function createSamplesFromBioData($bioDataRecords, $directory = null)
    {
        try {
            // Create a temporary directory for samples if none provided
            $samplesDir = $directory ?: storage_path('app/fingerprints/temp/' . uniqid());
            if (!file_exists($samplesDir)) {
                mkdir($samplesDir, 0755, true);
            }

            // Save each employee fingerprint to the samples directory
            foreach ($bioDataRecords as $bioData) {
                $filename = "employee_{$bioData->personal_info_id}.dat";
                $templatePath = $samplesDir . '/' . $filename;

                // Skip invalid templates
                if (empty($bioData->ISOTemplateBase64)) {
                    Log::warning("Empty ISO template for employee ID: " . $bioData->personal_info_id);
                    continue;
                }

                $decodedTemplate = base64_decode($bioData->ISOTemplateBase64);

                // Validate the decoded template
                if (strlen($decodedTemplate) < 30) {
                    Log::warning("Invalid template for employee ID: " . $bioData->personal_info_id . " (length: " . strlen($decodedTemplate) . ")");
                    continue;
                }

                file_put_contents($templatePath, $decodedTemplate);
                Log::debug("Saved template for employee ID: " . $bioData->personal_info_id . " to " . $filename);
            }

            return $samplesDir;

        } catch (Exception $e) {
            Log::error("Error creating fingerprint samples: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get the appropriate Python command
     *
     * @return string|null The Python command to use, or null if Python is not available
     */
    protected function getPythonCommand()
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
     * Clean up the samples directory
     *
     * @param string $directory The directory to clean up
     * @return void
     */
    public function cleanup($directory)
    {
        if (is_dir($directory)) {
            $files = glob($directory . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                } elseif (is_dir($file)) {
                    // Recursively clean up subdirectories
                    $this->cleanup($file);
                }
            }
            if (!@rmdir($directory)) {
                Log::warning("Could not completely remove directory: {$directory}");
            }
        }
    }
}
