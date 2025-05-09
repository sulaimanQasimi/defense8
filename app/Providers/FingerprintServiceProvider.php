<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Fingerprint\FingerprintService;

class FingerprintServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('fingerprint', function ($app) {
            return new FingerprintService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Create fingerprint sample directory if it doesn't exist
        $sampleDir = storage_path('app/fingerprints/samples');
        if (!file_exists($sampleDir)) {
            mkdir($sampleDir, 0755, true);
        }
    }
}
