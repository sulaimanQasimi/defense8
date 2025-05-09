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
     * @return string|null Filename of the matching sample or null if no match
     */
    public function match($fingerprintTemplate, $samplesDir)
    {
        try {
            if (!file_exists($fingerprintTemplate)) {
                throw new Exception("Fingerprint template file not found: {$fingerprintTemplate}");
            }

            if (!is_dir($samplesDir)) {
                throw new Exception("Samples directory not found: {$samplesDir}");
            }

            // Use the SecuGen matching script from our package
            $matchScript = dirname(__DIR__) . '/fingerprint-matching-master/match.py';

            if (!file_exists($matchScript)) {
                throw new Exception("Matching script not found: {$matchScript}");
            }

            // Get the appropriate Python command
            $pythonCommand = $this->getPythonCommand();
            if (!$pythonCommand) {
                throw new Exception("Python interpreter not found");
            }

            // Create and execute the matching command
            $command = $pythonCommand . " " . escapeshellarg($matchScript) . " " .
                     "--samples=" . escapeshellarg($samplesDir) . " " .
                     "--fingerprint=" . escapeshellarg($fingerprintTemplate) . " " .
                     "2>&1";

            Log::debug("Running fingerprint match command: {$command}");

            exec($command, $output, $returnCode);

            $outputStr = implode(PHP_EOL, $output);
            Log::debug("Match command output: {$outputStr}, Return code: {$returnCode}");

            // If there was a match, it will be in the output
            if ($returnCode === 0 && !empty($output)) {
                $matchFile = trim($output[0]);
                Log::info("Fingerprint match found: {$matchFile}");
                return $matchFile;
            }

            Log::info("No fingerprint match found");
            return null;

        } catch (Exception $e) {
            Log::error("Error matching fingerprint: " . $e->getMessage());
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
                }
            }
            @rmdir($directory);
        }
    }
}
