<?php
namespace Sq\Guest;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Sq\Guest\Nova as NovaResource;

class GuestServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Nova::resources([
            NovaResource\Guest::class,
            NovaResource\GuestGate::class,
            NovaResource\GuestOption::class,
            NovaResource\Host::class,
        ]);

        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
        $this->loadViewsFrom(__DIR__ . "/../resources/views/", 'sqguest');

        // Register Routes
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . "/../routes/web.php");
        });

    }
    public function register()
    {

    }
    public function routes()
    {

    }
    public static function registerMenu(): MenuSection
    {
        return MenuSection::make(__('Guest'), [
            MenuItem::resource(NovaResource\Host::class),
            MenuItem::resource(NovaResource\Guest::class),
            MenuItem::resource(NovaResource\GuestOption::class),
            // Guest Report Menu Section
            MenuItem::link(__('Guest Report'), '/guest-report')
                ->canSee(fn() => auth()->user()->hasRole('super-admin')),
        ])->collapsable()
            ->collapsedByDefault()
            ->icon('fas fa-person-shelter fa-2x');
    }
    protected function routeConfiguration()
    {
        return [
            // 'domain' => config('nova.domain', null),
            'as' => 'sqguest.',
            // 'prefix' => 'nova-api',
            'middleware' => ['web', 'auth'],

        ];
    }
}
