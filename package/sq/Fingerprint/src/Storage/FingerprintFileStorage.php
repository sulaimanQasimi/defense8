<?php

namespace Sq\Fingerprint\Storage;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FingerprintFileStorage
{
    /**
     * Get the directory path for storing fingerprint templates
     *
     * @return string
     */
    public function getStoragePath()
    {
        return storage_path('app/fingerprints');
    }

    /**
     * Save a fingerprint template to a file
     *
     * @param int $cardInfoId The CardInfo ID to use as filename
     * @param string $templateBase64 The fingerprint template in base64 format
     * @return bool Whether the save was successful
     */
    public function saveTemplate($cardInfoId, $templateBase64)
    {
        if (empty($templateBase64)) {
            return false;
        }

        $templatesDir = $this->getStoragePath();
        if (!file_exists($templatesDir)) {
            mkdir($templatesDir, 0755, true);
        }

        $templateFile = $templatesDir . '/cardinfo_' . $cardInfoId . '.dat';
        return file_put_contents($templateFile, base64_decode($templateBase64)) !== false;
    }

    /**
     * Load a fingerprint template from a file
     *
     * @param int $cardInfoId The CardInfo ID to use as filename
     * @return string|null The fingerprint template in binary format or null if not found
     */
    public function loadTemplate($cardInfoId)
    {
        $templateFile = $this->getStoragePath() . '/cardinfo_' . $cardInfoId . '.dat';
        if (!file_exists($templateFile)) {
            return null;
        }

        return file_get_contents($templateFile);
    }

    /**
     * Load a fingerprint template from a file and return it in base64 format
     *
     * @param int $cardInfoId The CardInfo ID to use as filename
     * @return string|null The fingerprint template in base64 format or null if not found
     */
    public function loadTemplateBase64($cardInfoId)
    {
        $template = $this->loadTemplate($cardInfoId);
        if ($template === null) {
            return null;
        }

        return base64_encode($template);
    }

    /**
     * Check if a fingerprint template file exists
     *
     * @param int $cardInfoId The CardInfo ID to check
     * @return bool Whether the file exists
     */
    public function hasTemplate($cardInfoId)
    {
        $templateFile = $this->getStoragePath() . '/cardinfo_' . $cardInfoId . '.dat';
        return file_exists($templateFile);
    }

    /**
     * Delete a fingerprint template file
     *
     * @param int $cardInfoId The CardInfo ID to delete
     * @return bool Whether the deletion was successful
     */
    public function deleteTemplate($cardInfoId)
    {
        $templateFile = $this->getStoragePath() . '/cardinfo_' . $cardInfoId . '.dat';
        if (!file_exists($templateFile)) {
            return true;
        }

        return @unlink($templateFile);
    }

    /**
     * List all template files
     *
     * @return array Array of CardInfo IDs that have template files
     */
    public function listTemplates()
    {
        $templatesDir = $this->getStoragePath();
        if (!file_exists($templatesDir)) {
            return [];
        }

        $files = glob($templatesDir . '/cardinfo_*.dat');
        $cardInfoIds = [];

        foreach ($files as $file) {
            $filename = basename($file);
            if (preg_match('/^cardinfo_(\d+)\.dat$/', $filename, $matches)) {
                $cardInfoIds[] = (int)$matches[1];
            }
        }

        return $cardInfoIds;
    }
}
