<?php

namespace Spatie\BackupTool;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use Spatie\BackupTool\Http\Middleware\Authorize;

class BackupToolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/nova-backup-tool.php' => config_path('nova-backup-tool.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/lang/' => resource_path('lang/vendor/nova-backup-tool'),
        ]);

        $this->registerTranslations();

        $this->app->booted(function () {
            $this->routes();
        });

        $this->provideConfigToScript();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/nova-backup-tool.php', 'nova-backup-tool');
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Nova::router(config('nova.api_middleware', []), 'backups')
            ->group(__DIR__.'/../routes/inertia.php');

        Route::middleware(config('nova.api_middleware', []))
            ->prefix('/nova-vendor/spatie/backup-tool')
            ->group(
                __DIR__.'/../routes/api.php'
            );
    }

    protected function provideConfigToScript()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::provideToScript([
                'nova_backup_tool' => [
                    'polling' => config('nova-backup-tool.polling'),
                    'polling_interval' => config('nova-backup-tool.polling_interval'),
                ],
            ]);
        });
    }

    protected function registerTranslations()
    {
        Nova::serving(function (ServingNova $event) {
            $currentLocale = app()->getLocale();

            Nova::translations(__DIR__.'/../resources/lang/'.$currentLocale.'.json');
            Nova::translations(resource_path('lang/vendor/nova-backup-tool/'.$currentLocale.'.json'));
            Nova::translations(lang_path('vendor/nova-backup-tool/'.$currentLocale.'.json'));
        });

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'BackupTool');
        $this->loadJSONTranslationsFrom(__DIR__.'/../resources/lang');
        $this->loadJSONTranslationsFrom(resource_path('lang/vendor/nova-backup-tool'));
        $this->loadJSONTranslationsFrom(lang_path('vendor/nova-backup-tool'));
    }
}
