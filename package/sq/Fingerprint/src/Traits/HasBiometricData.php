<?php

namespace Sq\Fingerprint\Traits;

use Sq\Fingerprint\Models\BiometricData;
use Sq\Fingerprint\Facades\FingerprintStorage;

trait HasBiometricData
{
    /**
     * Get the biometric data associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function biometricData()
    {
        return $this->hasOne(BiometricData::class, 'record_id', $this->getBiometricKeyName());
    }

    /**
     * Get the name of the key for biometric data relationship.
     *
     * @return string
     */
    public function getBiometricKeyName()
    {
        return $this->biometricKeyName ?? 'id';
    }

    /**
     * Set biometric data for this model.
     *
     * @param array $data
     * @return \Sq\Fingerprint\Models\BiometricData
     */
    public function setBiometricData(array $data)
    {
        $biometricData = $this->biometricData ?? new BiometricData();
        $biometricData->record_id = $this->{$this->getBiometricKeyName()};

        // Fill in the biometric data
        $biometricData->fill($data);

        // Save the biometric data
        $biometricData->save();

        // Save the template as a file using the storage facade
        $recordId = $this->{$this->getBiometricKeyName()};
        $templateData = $data['ISOTemplateBase64'] ?? $data['TemplateBase64'] ?? null;
        if (!empty($templateData)) {
            FingerprintStorage::saveTemplate($recordId, $templateData);
        }

        return $biometricData;
    }

    /**
     * Delete biometric data for this model.
     *
     * @return bool|null
     */
    public function deleteBiometricData()
    {
        // Delete the file if it exists
        $recordId = $this->{$this->getBiometricKeyName()};
        FingerprintStorage::deleteTemplate($recordId);

        if ($this->biometricData) {
            return $this->biometricData->delete();
        }

        return null;
    }

    /**
     * Verify fingerprint against this model's stored template.
     *
     * @param string $isoTemplateBase64
     * @return array
     */
    public function verifyFingerprint($isoTemplateBase64)
    {
        $recordId = $this->{$this->getBiometricKeyName()};
        $hasFileTemplate = FingerprintStorage::hasTemplate($recordId);
        $hasDbTemplate = $this->biometricData && $this->biometricData->ISOTemplateBase64;

        // Check if we have a template available (either file or database)
        if (!$hasFileTemplate && !$hasDbTemplate) {
            return [
                'success' => false,
                'match' => false,
                'message' => 'No stored fingerprint template for this record'
            ];
        }

        // Create temporary files for comparison
        $tempFile1 = tempnam(sys_get_temp_dir(), 'fp_verify1_');
        $tempFile2 = tempnam(sys_get_temp_dir(), 'fp_verify2_');

        file_put_contents($tempFile1, base64_decode($isoTemplateBase64));

        // Use the file-based template if available, otherwise use the database template
        if ($hasFileTemplate) {
            $storedTemplate = FingerprintStorage::loadTemplate($recordId);
            file_put_contents($tempFile2, $storedTemplate);
        } else {
            file_put_contents($tempFile2, base64_decode($this->biometricData->ISOTemplateBase64));
        }

        // Get the fingerprint service
        $fingerprintService = app(\Sq\Fingerprint\Services\FingerprintService::class);

        // Compare the templates
        $score = $fingerprintService->compareTemplates($tempFile1, $tempFile2);

        // Clean up
        @unlink($tempFile1);
        @unlink($tempFile2);

        // Check if it's a match
        $threshold = config('fingerprint.threshold', 25);
        $isMatch = $score >= $threshold;

        return [
            'success' => true,
            'match' => $isMatch,
            'score' => $score,
            'threshold' => $threshold,
            'template_source' => $hasFileTemplate ? 'file' : 'database',
            'message' => $isMatch ? 'Fingerprint verified successfully' : 'Fingerprint does not match'
        ];
    }
}
