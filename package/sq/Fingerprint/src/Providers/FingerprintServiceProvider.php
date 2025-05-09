<?php

namespace Sq\Fingerprint\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Sq\Fingerprint\Services\FingerprintService;

class FingerprintServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FingerprintService::class, function ($app) {
            return new FingerprintService();
        });

        // Register package configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/fingerprint.php', 'fingerprint'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sqfingerprint');

        // Register routes
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });

        // Publish configuration
        $this->publishes([
            __DIR__ . '/../config/fingerprint.php' => config_path('fingerprint.php'),
        ], 'config');

        // Publish views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/sqfingerprint'),
        ], 'views');

        // Publish assets
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/sqfingerprint'),
        ], 'public');
    }

    /**
     * Get the route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration()
    {
        return [
            'as' => 'sqfingerprint.',
            'prefix' => 'sq/modules/fingerprint',
            'middleware' => ['web', 'auth'],
        ];
    }
}