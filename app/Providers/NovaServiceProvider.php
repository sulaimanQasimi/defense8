<?php

namespace App\Providers;

use Acme\AppSetting\AppSetting;
use Acme\GuestReport\GuestReport;
use Acme\OilReport\OilReport;
use Acme\PriceTracker\PriceTracker;
use App\Nova\Dashboards\GraphDashboard;
use App\Nova\Dashboards\Main;
use App\Nova\User;
use App\Nova\Video;
use App\Support\Defense\PermissionTranslation;
use Bolechen\NovaActivitylog\Resources\Activitylog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Joedixon\NovaTranslation\NovaTranslation;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Permission;
use App\Nova\Role;
use Spatie\BackupTool\BackupTool;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        // Nova::withoutThemeSwitcher();
        // Left to right Direction
        Nova::enableRTL();


        Nova::userMenu(function (Request $request, Menu $menu) {
            return $menu
                ->append(
                    MenuItem::externalLink(__('Monitor'), url('/' . config('telescope.path')))
                        ->openInNewTab()
                        ->canSee(fn() => auth()->user()->hasRole('super-admin'))
                )
                ->prepend(MenuItem::externalLink(__('My Profile'), route('profile.show'))->openInNewTab());
        });

        // Side Bar Menu
        Nova::mainMenu(fn(Request $request) => [

            MenuItem::link(__('چت'), '/chats'),
            MenuSection::dashboard(Main::class)->icon('fas fa-database fa-2x'),
            MenuSection::dashboard(GraphDashboard::class)
                ->canSee(fn() => auth()->user()->isSuperAdmin())->icon('fas fa-chart-pie fa-2x')

                ->withBadge(function () {
                    return 'جدید';
                }),

            // Guest/Host Menu
            \Sq\Guest\GuestServiceProvider::registerMenu(),
            // Employee Menu
            \Sq\Employee\EmployeeServiceProvider::registerMenu(),

            //Oil Disterbution and Oil Import Menu
            \Sq\Oil\OilServiceProvider::registerMenu(),

            //Location Menu
            \Sq\Location\LocationServiceProvider::registerMenu(),

            MenuSection::make(__('Administration'), [
                MenuItem::resource(Permission::class),
                MenuItem::resource(Role::class),
                MenuItem::resource(User::class),


                MenuItem::externalLink(__("Create Token"), url("user/api-tokens"))
                    ->canSee(fn() => auth()->user()->hasRole('api-token'))->openInNewTab(),
            ])->icon('fas fa-coins fa-2x')->collapsable()->collapsedByDefault(),


            MenuSection::make(__("System"), [
                MenuItem::resource(Activitylog::class)->canSee(fn() => auth()->user()->hasRole('super-admin')),
                MenuItem::make(__('Backups'))
                    ->path('/backups')
                    ->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),
                MenuItem::make(__('App Setting'))
                    ->path('/app-setting')
                    ->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),


                MenuItem::externalLink(__("Change Application Language", ['lang' => trans("Dari")]), route("app.setting.language", ['file' => 'fa']))
                    ->canSee(fn() => auth()->user()->hasPermissionTo('change_language')),


                MenuItem::externalLink(__("Change Application Language", ['lang' => trans("Pashto")]), route("app.setting.language", ['file' => 'pa']))
                    ->canSee(fn() => auth()->user()->hasPermissionTo('change_language')),

                MenuItem::externalLink(__("Change Application Language", ['lang' => trans("Arabic")]), route("app.setting.language", ['file' => 'ar']))
                    ->canSee(fn() => auth()->user()->hasPermissionTo('change_language')),
                MenuItem::externalLink(__("Educational Videos of System"), route("youtube.list")),
                MenuSection::resource(Video::class)
            ])->icon('fas fa-toolbox fa-2x')->collapsable()->collapsedByDefault(),
            // MenuSection::dashboard(EducationalVideo::class)->icon('fab fa-youtube fa-2x'),

        ]);

        Nova::footer(fn($request) => "Powered By MOD");
    }


    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            // ->withPasswordResetRoutes()
            ->register();
    }

    protected function gate()
    {
        FacadesGate::define('viewNova', fn($user) => in_array($user->email, [
            //
        ]));
    }

    protected function dashboards()
    {
        return [
            new Main,
            new GraphDashboard,
            // new EducationalVideo,
            new \Sq\Oil\Nova\Dashboards\OilDistribution(),
        ];
    }

    public function tools()
    {
        return [

            new \Sereny\NovaPermissions\NovaPermissions(),
            new \Bolechen\NovaActivitylog\NovaActivitylog(),
            (new BackupTool)
                ->canSee(fn() => auth()->user()
                    ->hasRole('super-admin')),

            new \Badinansoft\LanguageSwitch\LanguageSwitch,

            // new \GeneaLabs\NovaPassportManager\NovaPassportManager,
            (new PriceTracker)->canSee(fn() => auth()->user()->hasPermissionTo(PermissionTranslation::viewAny("Card Info"))),

            (new GuestReport)->canSee(fn() => auth()->user()->hasRole('super-admin')),
            (new OilReport())->canSee(fn() => auth()->user()->hasRole('super-admin')),
            (new AppSetting())->canSee(fn() => auth()->user()->hasRole('super-admin')),
            new \Acme\Forum\Forum(),
            // new NovaTranslation(),

        ];
    }
    public function register(): void
    {
        //
    }
}
