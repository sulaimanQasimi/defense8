<?php
namespace Sq\Location;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;

class LocationServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Nova::resources([
            \Sq\Location\Nova\Province::class,
            \Sq\Location\Nova\District::class,
            \Sq\Location\Nova\Village::class,
        ]);

        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");

    }
    public function register()
    {

    }
    public function routes()
    {

    }
    public static function registerMenu():MenuSection
    {
        return  // Location Menu Section
            MenuSection::make(__('Location'), [
                MenuItem::resource(\Sq\Location\Nova\Province::class),
                MenuItem::resource(\Sq\Location\Nova\District::class),
                MenuItem::resource(\Sq\Location\Nova\Village::class),
            ])->icon('fas fa-globe fa-2x')->collapsable()->collapsedByDefault();
    }
}
