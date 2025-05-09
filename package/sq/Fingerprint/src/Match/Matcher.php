<?php

namespace Sq\Fingerprint\Match;

use Illuminate\Http\UploadedFile;

class Matcher
{
    /**
     * The match service instance.
     *
     * @var MatchService
     */
    protected $matchService;

    /**
     * Create a new Matcher instance.
     *
     * @param MatchService $matchService
     * @return void
     */
    public function __construct(MatchService $matchService = null)
    {
        $this->matchService = $matchService ?: new MatchService();
    }

    /**
     * Match a fingerprint against samples.
     *
     * @param string $samplesDir Directory containing fingerprint samples
     * @param string|UploadedFile $fingerprintToMatch Path to fingerprint or uploaded file
     * @return string|null Filename of the matching sample or null if no match
     */
    public function match(string $samplesDir, $fingerprintToMatch)
    {
        return $this->matchService->match($samplesDir, $fingerprintToMatch);
    }

    /**
     * Static method to match a fingerprint against samples.
     *
     * @param string $samplesDir Directory containing fingerprint samples
     * @param string|UploadedFile $fingerprintToMatch Path to fingerprint or uploaded file
     * @return string|null Filename of the matching sample or null if no match
     */
    public static function matchFingerprint(string $samplesDir, $fingerprintToMatch)
    {
        $service = new MatchService();
        return $service->match($samplesDir, $fingerprintToMatch);
    }
} 