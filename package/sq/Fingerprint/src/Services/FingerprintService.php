<?php

namespace Sq\Fingerprint\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Sq\Fingerprint\Models\BiometricData;

class FingerprintService
{
    /**
     * Store a fingerprint template.
     *
     * @param array $data The fingerprint data (containing templates)
     * @param string $identifier A unique identifier for this fingerprint
     * @return bool
     */
    public function store(array $data, string $identifier): bool
    {
        try {
            // Save to database using BiometricData model
            $bioData = BiometricData::firstOrNew(['record_id' => $identifier]);
            $bioData->fill($data);
            $bioData->save();

            // Also save to file system for matching
            $storageDir = $this->getStoragePath();

            // Create the directory if it doesn't exist
            if (!is_dir($storageDir)) {
                mkdir($storageDir, 0755, true);
            }

            // Save all template formats
            foreach (['ISOTemplateBase64', 'TemplateBase64', 'BMPBase64'] as $format) {
                if (isset($data[$format]) && !empty($data[$format])) {
                    $extension = $this->getExtensionForFormat($format);
                    $filePath = "{$storageDir}/{$identifier}.{$extension}";
                    file_put_contents($filePath, base64_decode($data[$format]));
                }
            }

            return true;
        } catch (Exception $e) {
            Log::error("Error storing fingerprint: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a stored fingerprint.
     *
     * @param string $identifier The identifier of the fingerprint to delete
     * @return bool
     */
    public function delete(string $identifier): bool
    {
        try {
            // Delete from database
            $bioData = BiometricData::where('record_id', $identifier)->first();
            if ($bioData) {
                $bioData->delete();
            }

            // Delete from file system
            $storageDir = $this->getStoragePath();

            // Delete all possible formats
            foreach (['iso', 'template', 'bmp'] as $extension) {
                $filePath = "{$storageDir}/{$identifier}.{$extension}";
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            return true;
        } catch (Exception $e) {
            Log::error("Error deleting fingerprint: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Match a fingerprint against stored templates.
     *
     * @param array $data The fingerprint data to match
     * @param array $identifiers Array of identifiers to match against, or empty for all
     * @param bool $debug Whether to return debug information
     * @return array|bool Return match result or false on error
     */
    public function match(array $data, array $identifiers = [], bool $debug = false)
    {
        try {
            $storageDir = $this->getStoragePath();
            $matchMethod = null;
            $matchScore = 0;
            $matchedId = null;
            $debugInfo = [];

            // Check if we have a valid template
            if (empty($data['ISOTemplateBase64']) && empty($data['TemplateBase64']) && empty($data['BMPBase64'])) {
                throw new Exception("No valid template provided for matching");
            }

            // If no identifiers provided, get all IDs from database
            if (empty($identifiers)) {
                $records = BiometricData::whereNotNull('ISOTemplateBase64')
                    ->orWhereNotNull('TemplateBase64')
                    ->get();

                $identifiers = $records->pluck('record_id')->toArray();
            }

            if ($debug) {
                $debugInfo['candidateCount'] = count($identifiers);
                $debugInfo['matchAttempts'] = [];
            }

            // Try each matching method in order of preference
            foreach ($identifiers as $identifier) {
                $matchResult = $this->tryMatch($data, $identifier, $debug);

                if ($debug) {
                    $debugInfo['matchAttempts'][$identifier] = $matchResult;
                }

                if ($matchResult['matched'] && $matchResult['score'] > $matchScore) {
                    $matchScore = $matchResult['score'];
                    $matchedId = $identifier;
                    $matchMethod = $matchResult['method'];
                }
            }

            $result = [
                'matched' => $matchedId !== null,
                'identifier' => $matchedId,
                'score' => $matchScore,
                'method' => $matchMethod
            ];

            // If a match was found, include the record details
            if ($matchedId !== null) {
                $bioData = BiometricData::where('record_id', $matchedId)->first();
                if ($bioData) {
                    $result['data'] = $bioData->toArray();
                }
            }

            if ($debug) {
                $result['debug'] = $debugInfo;
            }

            return $result;
        } catch (Exception $e) {
            Log::error("Error matching fingerprint: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Try to match a fingerprint using all available methods.
     *
     * @param array $data The fingerprint data
     * @param string $identifier The identifier to match against
     * @param bool $debug Whether to collect debug information
     * @return array
     */
    protected function tryMatch(array $data, string $identifier, bool $debug): array
    {
        $storageDir = $this->getStoragePath();
        $threshold = config('fingerprint.threshold', 25);
        $matchResult = [
            'matched' => false,
            'score' => 0,
            'method' => null
        ];

        // Get the record from the database
        $bioData = BiometricData::where('record_id', $identifier)->first();

        if (!$bioData) {
            if ($debug) {
                Log::debug("No biometric data found for identifier: {$identifier}");
            }
            return $matchResult;
        }

        // First try proprietary template match if available
        if (!empty($data['TemplateBase64']) && !empty($bioData->TemplateBase64)) {
            $score = $this->matchTemplates($data['TemplateBase64'], base64_decode($bioData->TemplateBase64));
            if ($score >= $threshold) {
                return [
                    'matched' => true,
                    'score' => $score,
                    'method' => 'proprietary'
                ];
            }
            $matchResult['score'] = max($matchResult['score'], $score);
        }

        // Next try ISO template match
        if (!empty($data['ISOTemplateBase64']) && !empty($bioData->ISOTemplateBase64)) {
            $score = $this->matchISOTemplates($data['ISOTemplateBase64'], base64_decode($bioData->ISOTemplateBase64));
            if ($score >= $threshold) {
                return [
                    'matched' => true,
                    'score' => $score,
                    'method' => 'iso'
                ];
            }
            $matchResult['score'] = max($matchResult['score'], $score);
        }

        // Finally try image-based match as a last resort
        if (!empty($data['BMPBase64']) && !empty($bioData->BMPBase64)) {
            $score = $this->matchImages($data['BMPBase64'], base64_decode($bioData->BMPBase64));
            if ($score >= $threshold) {
                return [
                    'matched' => true,
                    'score' => $score,
                    'method' => 'image'
                ];
            }
            $matchResult['score'] = max($matchResult['score'], $score);
        }

        return $matchResult;
    }

    /**
     * Match two proprietary templates.
     *
     * @param string $templateBase64 Base64 encoded template
     * @param string $storedTemplate Raw binary template
     * @return int Match score (0-100)
     */
    protected function matchTemplates(string $templateBase64, string $storedTemplate): int
    {
        // Check for our enhanced matching scripts
        $sdkMatchScript = dirname(__DIR__) . '/FingerprintMatch/match.py';
        $simpleMatchScript = dirname(__DIR__) . '/FingerprintMatch/simple_match.py';

        // Create temporary files for the templates
        $tempDir = sys_get_temp_dir();
        $templatePath = tempnam($tempDir, 'fp1_');
        $storedPath = tempnam($tempDir, 'fp2_');
        $samplesDir = $tempDir . '/fp_samples_' . uniqid();

        if (!is_dir($samplesDir)) {
            mkdir($samplesDir, 0755, true);
        }

        try {
            // Write data to temp files
            file_put_contents($templatePath, base64_decode($templateBase64));
            file_put_contents($samplesDir . '/stored.dat', $storedTemplate);

            // Try SDK-based matching if available
            if (file_exists($sdkMatchScript)) {
                $pythonCmd = $this->getPythonCommand();
                if ($pythonCmd) {
                    $command = escapeshellcmd("{$pythonCmd} {$sdkMatchScript} --fingerprint={$templatePath} --samples={$samplesDir} --security=1");
                    $output = shell_exec($command . " 2>&1");

                    if ($output && strpos($output, 'stored.dat') !== false) {
                        $this->cleanupTempFiles($templatePath, $storedPath, $samplesDir);
                        return 100; // Full match
                    }
                }
            }

            // Try simple matching if available
            if (file_exists($simpleMatchScript)) {
                $pythonCmd = $this->getPythonCommand();
                if ($pythonCmd) {
                    $command = escapeshellcmd("{$pythonCmd} {$simpleMatchScript} --fingerprint={$templatePath} --samples={$samplesDir} --method=binary");
                    $output = shell_exec($command . " 2>&1");

                    if ($output) {
                        // Extract similarity percentage if available
                        if (preg_match('/similarity: (\d+(\.\d+)?)%/', $output, $matches)) {
                            $this->cleanupTempFiles($templatePath, $storedPath, $samplesDir);
                            return (int)$matches[1];
                        }

                        // If no percentage but match found
                        if (strpos($output, 'Match found: stored.dat') !== false) {
                            $this->cleanupTempFiles($templatePath, $storedPath, $samplesDir);
                            return $this->calculateSimilarityScore(base64_decode($templateBase64), $storedTemplate);
                        }
                    }
                }
            }

            // Fall back to the binary method
            $binary = config('fingerprint.match_binary');

            if ($binary && file_exists($binary)) {
                // Execute the binary
                $command = escapeshellcmd("{$binary} match -p {$templatePath} {$storedPath}");
                $output = shell_exec($command);

                // Parse the output
                $score = $this->parseMatchOutput($output);
                $this->cleanupTempFiles($templatePath, $storedPath, $samplesDir);
                return $score;
            }

            // If all else fails, calculate similarity directly
            $score = $this->calculateSimilarityScore(base64_decode($templateBase64), $storedTemplate);
            $this->cleanupTempFiles($templatePath, $storedPath, $samplesDir);
            return $score;

        } catch (\Exception $e) {
            Log::error("Error matching templates: " . $e->getMessage());
            $this->cleanupTempFiles($templatePath, $storedPath, $samplesDir);
            return 0;
        }
    }

    /**
     * Match two ISO templates.
     *
     * @param string $isoBase64 Base64 encoded ISO template
     * @param string $storedIso Raw binary ISO template
     * @return int Match score (0-100)
     */
    protected function matchISOTemplates(string $isoBase64, string $storedIso): int
    {
        // ISO templates can use the same matching logic
        return $this->matchTemplates($isoBase64, $storedIso);
    }

    /**
     * Calculate similarity score between two binary templates
     *
     * @param string $template1 First template
     * @param string $template2 Second template
     * @return int Similarity score (0-100)
     */
    protected function calculateSimilarityScore(string $template1, string $template2): int
    {
        // Same template - exact match
        if ($template1 === $template2) {
            return 100;
        }

        // Different sizes - compare the minimum overlapping portion
        $minLength = min(strlen($template1), strlen($template2));
        $maxLength = max(strlen($template1), strlen($template2));

        // If size difference is too large, lower the max score
        $sizeFactor = $minLength / $maxLength;

        // Count matching bytes
        $matchingBytes = 0;
        for ($i = 0; $i < $minLength; $i++) {
            if ($template1[$i] === $template2[$i]) {
                $matchingBytes++;
            }
        }

        // Calculate similarity percentage
        $similarityScore = ($matchingBytes / $minLength) * 100 * $sizeFactor;

        return (int)$similarityScore;
    }

    /**
     * Get the Python command to use
     *
     * @return string|null Python command or null if not available
     */
    protected function getPythonCommand()
    {
        // Try different Python commands
        foreach (['python', 'python3', 'py'] as $cmd) {
            $output = null;
            $returnCode = null;
            exec("{$cmd} --version 2>&1", $output, $returnCode);

            if ($returnCode === 0) {
                return $cmd;
            }
        }

        return null;
    }

    /**
     * Cleanup temporary files created for matching
     *
     * @param string $templatePath
     * @param string $storedPath
     * @param string $samplesDir
     * @return void
     */
    protected function cleanupTempFiles(string $templatePath, string $storedPath, string $samplesDir): void
    {
        // Check if we should preserve temp files (for debugging)
        if (config('fingerprint.preserve_temp_files', false)) {
            if (config('fingerprint.debug', false)) {
                Log::info("FingerprintService: Preserving temporary files for debugging purposes");
            }
            return;
        }

        @unlink($templatePath);
        @unlink($storedPath);

        if (is_dir($samplesDir)) {
            $files = glob($samplesDir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
            @rmdir($samplesDir);
        }
    }

    /**
     * Match two fingerprint images.
     *
     * @param string $imageBase64 Base64 encoded image
     * @param string $storedImage Raw binary image
     * @return int Match score (0-100)
     */
    protected function matchImages(string $imageBase64, string $storedImage): int
    {
        // Image-based matching is less accurate but can be a fallback
        // For now, simulate a match score
        return $this->simulateMatchScore($imageBase64, $storedImage, 0.8); // Lower coefficient for less accuracy
    }

    /**
     * Parse the output from the matching binary.
     *
     * @param string|null $output The command output
     * @return int The match score
     */
    protected function parseMatchOutput(?string $output): int
    {
        if (empty($output)) {
            return 0;
        }

        // Pattern depends on your matching binary
        if (preg_match('/score:\s*(\d+)/i', $output, $matches)) {
            return (int) $matches[1];
        }

        return 0;
    }

    /**
     * Simulate a match score for testing purposes.
     *
     * @param string $data1 First data sample
     * @param string $data2 Second data sample
     * @param float $coefficient Accuracy coefficient (0-1)
     * @return int
     */
    protected function simulateMatchScore(string $data1, string $data2, float $coefficient = 1.0): int
    {
        // This is just for testing/simulation
        // In a real application, you would use actual fingerprint matching algorithms

        // For testing, if we're matching a template against itself, return a high score
        if (base64_decode($data1) === $data2) {
            return (int) (100 * $coefficient);
        }

        // Otherwise return a random score
        // We hash both inputs to make the result deterministic for the same inputs
        $hash1 = md5($data1);
        $hash2 = md5($data2);
        $combinedHash = md5($hash1 . $hash2);

        // Convert hash to integer and get a value between 0-100
        $int = hexdec(substr($combinedHash, 0, 8));
        $score = $int % 101;

        // Apply coefficient
        return (int) ($score * $coefficient);
    }

    /**
     * Get the file extension for a specific template format.
     *
     * @param string $format The template format
     * @return string
     */
    protected function getExtensionForFormat(string $format): string
    {
        switch ($format) {
            case 'ISOTemplateBase64':
                return 'iso';
            case 'TemplateBase64':
                return 'template';
            case 'BMPBase64':
                return 'bmp';
            default:
                return 'dat';
        }
    }

    /**
     * Get the storage path for fingerprint templates.
     *
     * @return string
     */
    protected function getStoragePath(): string
    {
        return config('fingerprint.storage_path', storage_path('app/fingerprints'));
    }

    /**
     * Get the temporary path for fingerprint operations.
     *
     * @return string
     */
    protected function getTempPath(): string
    {
        $path = config('fingerprint.temp_path', storage_path('app/fingerprints/temp'));

        // Ensure the directory exists
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        return $path;
    }

    /**
     * Create a samples directory from biometric data records.
     *
     * @param \Illuminate\Database\Eloquent\Collection $bioDataRecords
     * @return string|null Path to the samples directory or null if failed
     */
    public function createSamplesFromBioData($bioDataRecords)
    {
        // Create a temporary directory for the samples
        $tempDir = $this->getTempPath() . '/' . uniqid('samples_');

        // Ensure the directory exists
        if (!is_dir($tempDir)) {
            if (!mkdir($tempDir, 0755, true)) {
                Log::error("FingerprintService: Failed to create samples directory: {$tempDir}");
                return null;
            }
        }

        // Check if the directory was created successfully
        if (!is_dir($tempDir) || !is_writable($tempDir)) {
            Log::error("FingerprintService: Failed to create samples directory: {$tempDir}");
            return null;
        }

        // Log debug information
        if (config('fingerprint.debug', false)) {
            Log::debug("FingerprintService: Creating samples directory: {$tempDir}");
            Log::debug("FingerprintService: Processing " . $bioDataRecords->count() . " records");
        }

        // Get the minimum template size from config
        $minTemplateSize = config('fingerprint.min_template_size', 30);

        // Get template preference order from config
        $templatePreference = config('fingerprint.template_preference', ['ISOTemplateBase64', 'TemplateBase64', 'BMPBase64']);

        // Process each record
        foreach ($bioDataRecords as $bioData) {
            $templateProcessed = false;

            // Try each template format in order of preference
            foreach ($templatePreference as $templateFormat) {
                if (!empty($bioData->$templateFormat)) {
                    // Decode and validate the template
                    $templateData = base64_decode($bioData->$templateFormat);

                    if ($templateData === false || strlen($templateData) < $minTemplateSize) {
                        if (config('fingerprint.debug', false)) {
                            Log::warning("FingerprintService: Invalid {$templateFormat} for record {$bioData->id}: " .
                                         ($templateData === false ? "Decode failed" : "Size " . strlen($templateData) . " < {$minTemplateSize}"));
                        }
                        continue;
                    }

                    // Create the appropriate filename based on template type
                    $extension = $this->getExtensionForFormat($templateFormat);
                    $filename = "employee_{$bioData->id}.{$extension}";
                    $filePath = $tempDir . '/' . $filename;

                    // Save the template
                    if (file_put_contents($filePath, $templateData) === false) {
                        Log::error("FingerprintService: Failed to write template file for record {$bioData->id}: {$filePath}");
                        continue;
                    }

                    if (config('fingerprint.debug', false)) {
                        Log::debug("FingerprintService: Created {$extension} template file for record {$bioData->id}: {$filePath}");
                    }

                    $templateProcessed = true;
                }
            }

            // Log if no valid template was found for this record
            if (!$templateProcessed && config('fingerprint.debug', false)) {
                Log::warning("FingerprintService: No valid template found for record {$bioData->id}");
            }
        }

        return $tempDir;
    }

    /**
     * Clean up a samples directory.
     *
     * @param string $samplesDir Path to the samples directory
     * @return bool True if cleanup was successful
     */
    public function cleanup($samplesDir)
    {
        // Ensure the directory exists
        if (!is_dir($samplesDir)) {
            Log::error("FingerprintService: Samples directory does not exist: {$samplesDir}");
            return false;
        }

        // Check if we should preserve temp files (for debugging)
        if (config('fingerprint.preserve_temp_files', false)) {
            Log::info("FingerprintService: Preserving temporary files in {$samplesDir} for debugging purposes");
            return true;
        }

        // Log debug information
        if (config('fingerprint.debug', false)) {
            Log::debug("FingerprintService: Cleaning up samples directory: {$samplesDir}");
        }

        // Delete the directory and its contents recursively
        try {
            $this->deleteDirectory($samplesDir);

            if (config('fingerprint.debug', false)) {
                Log::debug("FingerprintService: Successfully cleaned up samples directory");
            }

            return true;
        } catch (\Exception $e) {
            Log::error("FingerprintService: Failed to clean up samples directory: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a directory and its contents recursively.
     *
     * @param string $dir The directory to delete
     * @return bool
     */
    protected function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }

        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object == "." || $object == "..") {
                continue;
            }

            $path = $dir . "/" . $object;

            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }

        return rmdir($dir);
    }
}