<?php

namespace Sq\Fingerprint;

use Illuminate\Support\ServiceProvider;
use Sq\Fingerprint\Match\MatchServiceProvider;

class FingerprintMatchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the Match service provider
        $this->app->register(MatchServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Nothing to bootstrap
    }
} 