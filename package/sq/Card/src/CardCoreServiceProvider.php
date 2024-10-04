<?php
namespace Sq\Card;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Livewire\Livewire;
use Sq\Card\Livewire\CardDesign;
use Sq\Card\Nova\PrintCard;
use Sq\Card\Nova\PrintCardFrame;

class CardCoreServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Livewire::component('sq-card-design', CardDesign::class);
        Nova::resources([
            PrintCardFrame::class,
            PrintCard::class
        ]);

        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . "/../routes/web.php");
        });
        $this->loadRoutesFrom(__DIR__ . "/../routes/api.php");

        $this->loadViewsFrom(__DIR__ . "/../resources/views/", 'sqcard');
        $this->loadJsonTranslationsFrom(__DIR__ . "/../langs");

        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . "/../resources/views/",
                'sqcard' => resource_path("views")
            ]);

        }

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('cards'),
          ], 'assets');


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
