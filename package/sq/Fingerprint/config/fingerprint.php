<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fingerprint Storage Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the fingerprint storage system.
    | Adjust these settings to control where and how fingerprint templates
    | are stored and matched.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Storage Path
    |--------------------------------------------------------------------------
    |
    | Path where fingerprint templates are stored. This is used by the
    | FingerprintStorage system to determine where to save templates.
    |
    */
    'storage_path' => storage_path('app/fingerprints'),

    /*
    |--------------------------------------------------------------------------
    | Temporary Directory
    |--------------------------------------------------------------------------
    |
    | Path for temporary files used during matching operations. This directory
    | will be cleaned up after matching operations.
    |
    */
    'temp_path' => storage_path('app/fingerprints/temp'),

    /*
    |--------------------------------------------------------------------------
    | Matching Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for the fingerprint matching process.
    |
    */

    // Main matching binary path (if available)
    'match_binary' => null,

    // Minimum similarity threshold for templates to be considered a match (0-100)
    'threshold' => 75,

    // Default security level (1=lowest, 2=normal, 3=high, 4=highest)
    'security_level' => 2,

    // Whether to fallback to binary comparison if SDK matching fails
    'use_binary_fallback' => true,

    /*
    |--------------------------------------------------------------------------
    | Python Settings
    |--------------------------------------------------------------------------
    |
    | Settings for Python scripts and environment.
    |
    */

    // Path to Python interpreter (null for auto-detect)
    'python_path' => null,

    // Python script paths
    'scripts' => [
        'match' => 'FingerprintMatch/match.py',
        'simple_match' => 'FingerprintMatch/simple_match.py',
    ],

    /*
    |--------------------------------------------------------------------------
    | Templates Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for template formats and quality.
    |
    */

    // Preferred template format order for matching
    'template_preference' => ['ISOTemplateBase64', 'TemplateBase64', 'BMPBase64'],

    // Minimum template size (in bytes) to be considered valid
    'min_template_size' => 30,

    /*
    |--------------------------------------------------------------------------
    | Debug Options
    |--------------------------------------------------------------------------
    |
    | Options for debugging fingerprint operations.
    |
    */

    // Enable or disable debug logging
    'debug' => env('FINGERPRINT_DEBUG', false),

    // Log detailed match information
    'log_matches' => env('FINGERPRINT_LOG_MATCHES', false),

    // Keep temporary matching files for debugging (use with caution)
    'preserve_temp_files' => env('FINGERPRINT_PRESERVE_TEMP', false),
];