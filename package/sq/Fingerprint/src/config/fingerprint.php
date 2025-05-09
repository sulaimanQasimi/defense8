<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fingerprint Storage Path
    |--------------------------------------------------------------------------
    |
    | This value determines the directory where fingerprint templates will be
    | temporarily stored during the matching process.
    |
    */
    'storage_path' => storage_path('app/fingerprints/temp'),

    /*
    |--------------------------------------------------------------------------
    | Matching Threshold
    |--------------------------------------------------------------------------
    |
    | This value determines the minimum score (0-100) required for a fingerprint
    | to be considered a match.
    |
    */
    'threshold' => 25,

    /*
    |--------------------------------------------------------------------------
    | Matching Algorithm Configuration
    |--------------------------------------------------------------------------
    |
    | These values configure the parameters used by the matching algorithm.
    |
    */
    'algorithm' => [
        'max_rotation' => 30,       // Maximum rotation in degrees to try during matching
        'max_distance' => 20,       // Maximum distance between minutiae to consider a match
        'angle_tolerance' => 45,    // Maximum angle difference (0-255) to consider a match
    ],

    /*
    |--------------------------------------------------------------------------
    | Fingerprint Matching Utility Path
    |--------------------------------------------------------------------------
    |
    | Path to the fingerprint matching binary (if using an external utility).
    |
    */
    'match_binary' => env('FINGERPRINT_MATCH_BINARY', '/usr/bin/FP'),

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | When enabled, additional debug information will be logged during
    | fingerprint capture and matching.
    |
    */
    'debug' => env('FINGERPRINT_DEBUG', false),
];
