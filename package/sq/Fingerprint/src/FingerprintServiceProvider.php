<?php

namespace Sq\Fingerprint;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Sq\Fingerprint\Services\FingerprintService;
use Sq\Fingerprint\Console\Commands\InstallCommand;
use Sq\Fingerprint\Console\Commands\MigrateTemplatesToFiles;
use Sq\Fingerprint\Storage\FingerprintFileStorage;

class FingerprintServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the configuration
        $this->mergeConfigFrom(
            __DIR__.'/config/fingerprint.php', 'fingerprint'
        );

        // Register the service
        $this->app->singleton(FingerprintService::class, function ($app) {
            return new FingerprintService();
        });

        // Register the fingerprint storage service
        $this->app->singleton('fingerprint.storage', function ($app) {
            return new FingerprintFileStorage();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                MigrateTemplatesToFiles::class,
            ]);
        }

        // Publish configuration
        $this->publishes([
            __DIR__.'/config/fingerprint.php' => config_path('fingerprint.php'),
        ], 'fingerprint-config');

        // Publish migrations
        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations'),
        ], 'migrations');

        // Load views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'sq-fingerprint');

        // Publish views
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/sq-fingerprint'),
        ], 'views');

        // Publish assets
        $this->publishes([
            __DIR__.'/public' => public_path('vendor/sq-fingerprint'),
        ], 'public');

        // Register routes
        $this->registerRoutes();
    }

    /**
     * Register the package routes.
     */
    protected function registerRoutes(): void
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        });
    }

    /**
     * Get the route group configuration.
     */
    protected function routeConfiguration(): array
    {
        return [
            'prefix' => 'fingerprint',
            'middleware' => ['web', 'auth'],
            'namespace' => 'Sq\Fingerprint\Http\Controllers',
        ];
    }
}
