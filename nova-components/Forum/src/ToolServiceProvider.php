<?php

namespace Acme\Forum;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use Acme\Forum\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });
        $this->vendors();
        Nova::serving(function (ServingNova $event) {
            //
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Nova::router(['nova', Authenticate::class, Authorize::class], 'forum')
            ->group(__DIR__ . '/../routes/inertia.php');

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/forum')
            ->group(__DIR__ . '/../routes/api.php');

        // forum Api
        Route::middleware(['nova', Authorize::class])
            ->prefix('/forum/api')
            ->name('forum.api.')
            ->namespace('\Acme\Forum\Http\Controllers\Api')
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/forum.php');
            });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    public function vendors()
    {

        $this->publishes([
            __DIR__ . '/../config/api.php' => config_path('forum.api.php'),
            __DIR__ . '/../config/web.php' => config_path('forum.web.php'),
            __DIR__ . '/../config/general.php' => config_path('forum.general.php'),
            __DIR__ . '/../config/integration.php' => config_path('forum.integration.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../translations/' => function_exists('lang_path') ? lang_path('vendor/forum') : resource_path('lang/vendor/forum'),
        ], 'translations');

        foreach (['api', 'web', 'general', 'integration'] as $name) {
            $this->mergeConfigFrom(__DIR__ . "/../config/{$name}.php", "forum.{$name}");
        }
    }
}
