<?php

namespace App\Services\Fingerprint;

class Fingerprint
{
    /**
     * The Fingerprint service instance.
     *
     * @var FingerprintService
     */
    protected $fingerprintService;

    /**
     * Create a new Fingerprint instance.
     *
     * @param FingerprintService $fingerprintService
     * @return void
     */
    public function __construct(FingerprintService $fingerprintService)
    {
        $this->fingerprintService = $fingerprintService;
    }

    /**
     * Match a fingerprint against samples
     *
     * @param string $samplesDir Directory containing fingerprint samples
     * @param string|\Illuminate\Http\UploadedFile $fingerprintToMatch Path to fingerprint or uploaded file
     * @return string|null Filename of the matching sample or null if no match
     */
    public static function match($samplesDir, $fingerprintToMatch)
    {
        $service = new FingerprintService();
        return $service->match($samplesDir, $fingerprintToMatch);
    }
}
