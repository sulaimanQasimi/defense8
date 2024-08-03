<?php
namespace Sq\Oil;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;

class OilServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Nova::resources([
            \Sq\Oil\Nova\Oil::class,
            \Sq\Oil\Nova\OilDisterbution::class,
        ]);

        $this->loadViewsFrom(__DIR__ . "/../resources/views/", 'sqoil');

        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . "/../routes/web.php");
        });

        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");

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
            'as' => 'sq.oil.',
            // 'prefix' => 'nova-api',
            'middleware' => ['web'],

        ];
    }
    public static function registerMenu(): MenuSection
    {
        return
            MenuSection::make(__('Oil Disterbution'), [
                MenuItem::dashboard(\Sq\Oil\Nova\Dashboards\OilDistribution::class),
                MenuItem::resource(\Sq\Oil\Nova\Oil::class),
                MenuItem::resource(\Sq\Oil\Nova\OilDisterbution::class),
                MenuItem::externalLink(trans("Oil Disterbution"), route('sq.oil.oil'))
                    ->canSee(fn() => auth()->user()->hasPermissionTo('access_to_disterbuted_oil_page'))
                    ->openInNewTab(),

                MenuItem::link(__('Oil Report'), '/oil-report')
                    ->canSee(fn() => auth()->user()->hasRole('super-admin')),
            ])->collapsable()->collapsedByDefault()->icon("fas fa-oil-well fa-2x");

    }
}
