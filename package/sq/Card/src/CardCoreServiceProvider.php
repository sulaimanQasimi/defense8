<?php
namespace Sq\Card;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Livewire\Livewire;
use Sq\Card\Livewire\CardDesign;
use Sq\Card\Nova\PrintCardFrame;

class CardCoreServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Livewire::component('sq-card-design', CardDesign::class);
        Nova::resources([
            PrintCardFrame::class
        ]);

        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . "/../routes/web.php");
        });

        $this->loadViewsFrom(__DIR__ . "/../resources/views/", 'sqcard');

        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . "/../resources/views/",
                'sqcard' => resource_path("views")
            ]);

        }

    }
    public function register()
    {

    }
    public function routes()
    {

    }
    protected function routeConfiguration()
    {
        return [
            // 'domain' => config('nova.domain', null),
            'as' => 'sq.',
            // 'prefix' => 'nova-api',
            'middleware' => ['web'],

        ];
    }
}
