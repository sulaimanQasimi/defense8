<?php

namespace Sq\Fingerprint\Match;

use Illuminate\Support\ServiceProvider;
use Sq\Fingerprint\Http\Controllers\CardInfoBiometricController;

class MatchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the matching service
        $this->app->singleton('fingerprint.match', function ($app) {
            return new Matcher();
        });

        // Register the match service class
        $this->app->singleton(MatchService::class, function ($app) {
            return new MatchService();
        });
        
        // Register the CardInfoBiometricController
        $this->app->singleton(CardInfoBiometricController::class, function ($app) {
            return new CardInfoBiometricController($app->make(MatchService::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Nothing to bootstrap here
    }
} 