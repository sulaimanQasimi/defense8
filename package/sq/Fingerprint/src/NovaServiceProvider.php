<?php

namespace Sq\Fingerprint;

use Illuminate\Support\ServiceProvider;

class NovaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Only register Nova components if Nova is installed
        if (!class_exists(\Laravel\Nova\Nova::class)) {
            return;
        }

        \Laravel\Nova\Nova::serving(function (\Laravel\Nova\Events\ServingNova $event) {
            \Laravel\Nova\Nova::script('sq-fingerprint', __DIR__.'/../dist/js/field.js');
            \Laravel\Nova\Nova::style('sq-fingerprint', __DIR__.'/../dist/css/field.css');
            
            // Register Nova resources
            if (class_exists(\Sq\Fingerprint\Nova\Resources\BiometricData::class)) {
                \Laravel\Nova\Nova::resources([
                    \Sq\Fingerprint\Nova\Resources\BiometricData::class,
                ]);
            }
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}