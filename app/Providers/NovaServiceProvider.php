<?php

namespace App\Providers;

use Acme\EmployeeChecker\EmployeeChecker;
use Acme\GuestReport\GuestReport;
use Acme\OilReport\OilReport;
use Acme\PriceTracker\PriceTracker;
use App\Nova\Card\CardInfo as CardCardInfo;
use App\Nova\Card\EmployeeVehicalCard;
use App\Nova\Card\GunCard;
use App\Nova\CardInfo;
use App\Nova\Dashboards\EducationalVideo;
use App\Nova\Dashboards\GraphDashboard;
use App\Nova\Dashboards\Main;
use App\Nova\Dashboards\OilDistribution;
use App\Nova\Department;
use App\Nova\District;
use App\Nova\Gate;
use App\Nova\Guest;
use App\Nova\GuestOption;
use App\Nova\Host;
use App\Nova\Oil;
use App\Nova\OilDisterbution;
use App\Nova\Province;
use App\Nova\User;
use App\Nova\Village;
use App\Nova\Website;
use Bolechen\NovaActivitylog\Resources\Activitylog;
use Crayon\NovaLanguageEditor\NovaLanguageEditor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuGroup;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Sereny\NovaPermissions\Nova\Permission;
use Sereny\NovaPermissions\Nova\Role;
use Spatie\BackupTool\BackupTool;
use Visanduma\NovaTwoFactor\NovaTwoFactor;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        // Left to right Direction
        Nova::enableRTL();


        Nova::userMenu(function (Request $request, Menu $menu) {
            return $menu
                ->append(
                    MenuItem::externalLink(__('Monitor'), url('/telescope'))
                        ->openInNewTab()
                        ->canSee(fn() => auth()->user()->hasRole('super-admin'))
                )
                ->prepend(MenuItem::externalLink(__('My Profile'), route('profile.show'))->openInNewTab());
        });

        // Side Bar Menu
        Nova::mainMenu(fn(Request $request) => [
            MenuSection::dashboard(Main::class)->icon('fas fa-database fa-2x'),
            MenuSection::dashboard(GraphDashboard::class)->icon('fas fa-chart-pie fa-2x'),

            // Guest Menu Section
            MenuSection::make(__('Guest'), [
                MenuItem::resource(Host::class),
                MenuItem::resource(Guest::class),
                // Guest Report Menu Section
                MenuItem::link(__('Guest Report'), '/guest-report')
                    ->canSee(fn() => auth()->user()->hasRole('super-admin')),
            ])->collapsable()
                ->collapsedByDefault()
                ->icon('fas fa-person-shelter fa-2x'),


            // Card and Employee Section
            MenuSection::make(__('Employees'), [

                // Department Menu Item
                MenuItem::resource(Department::class),

                // Gate Menu Item
                MenuItem::resource(Gate::class),

                // Employee Menu Item
                MenuItem::resource(CardCardInfo::class),

                // Employee Menu Item
                MenuItem::resource(EmployeeVehicalCard::class),

                // Employee Menu Item
                MenuItem::resource(GunCard::class),

                // Employee Check out Page
                MenuItem::externalLink(__("Employee Check Card"), route("employee.check.card"))
                ->canSee(fn() => \Illuminate\Support\Facades\Gate::allows('gateChecker', \App\Models\Gate::class)),

                // Self Employee Attendance
                MenuItem::externalLink(
                    __("Employee Attendance Check Self Department"),
                    route(
                        "department.employee.attendance.check",
                        ['department' => auth()->user()?->department]
                    )
                )->canSee(fn() => auth()->user()->hasPermissionTo('check own department attendance')),

                // Check Attendance of Department
                MenuItem::externalLink(__("Employee Attendance Check Department"), route("employee.attendance.check"))
                    ->canSee(fn() => auth()->user()->hasRole('super-admin')),

                // Report Generator of Attendance
                MenuItem::link(__("ATTENDANCE EMPLOYEE Report Generator"), 'price-tracker')->canSee(fn() => auth()->user()->hasRole('super-admin')),

                // Frame of Printable Card Menu Item
                MenuItem::resource(\Sq\Card\Nova\PrintCardFrame::class),


            ])->collapsable()->collapsedByDefault()->icon("fas fa-users-rectangle fa-2x"),
            MenuSection::make(__('Oil Disterbution'), [
                MenuItem::dashboard(OilDistribution::class),
                MenuItem::resource(Oil::class),
                MenuItem::resource(OilDisterbution::class),
                MenuItem::externalLink(trans("Oil Disterbution"), route('oil'))
                    ->canSee(fn() => auth()->user()->hasPermissionTo('access_to_disterbuted_oil_page'))
                    ->openInNewTab(),

                MenuItem::link(__('Oil Report'), '/oil-report')
                    ->canSee(fn() => auth()->user()->hasRole('super-admin')),
            ])->collapsable()->collapsedByDefault()->icon("fas fa-oil-well fa-2x"),

            // Location Menu Section
            MenuSection::make(__('Location'), [
                MenuItem::resource(Province::class),
                MenuItem::resource(District::class),
                MenuItem::resource(Village::class),
            ])->icon('fas fa-globe fa-2x')->collapsable()->collapsedByDefault(),


            MenuSection::make(__('Administration'), [
                MenuItem::resource(GuestOption::class),
                MenuItem::resource(Permission::class),
                MenuItem::resource(Role::class),
                MenuItem::resource(User::class),


                MenuItem::externalLink(__("See Other Website Data"), route("check.other-website-employee"))
                    ->canSee(fn() => auth()->user()->hasPermissionTo('see-other-website-data'))
                    ->openInNewTab(),

                MenuItem::externalLink(__("Create Token"), url("user/api-tokens"))
                    ->canSee(fn() => auth()->user()->hasRole('api-token'))->openInNewTab(),
            ])->icon('fas fa-coins fa-2x')->collapsable()->collapsedByDefault(),


            MenuSection::make(__("System"), [
                MenuItem::resource(Activitylog::class)->canSee(fn() => auth()->user()->hasRole('super-admin')),
                MenuItem::resource(Website::class)->canSee(fn() => auth()->user()->hasRole('super-admin')),
                MenuItem::make(__('Backups'))
                    ->path('/backups')
                    ->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),


                MenuItem::externalLink(__("Change Application Language", ['lang' => trans("Dari")]), route("app.setting.language", ['file' => 'fa']))
                    ->canSee(fn() => auth()->user()->hasPermissionTo('change_language')),


                MenuItem::externalLink(__("Change Application Language", ['lang' => trans("Pashto")]), route("app.setting.language", ['file' => 'pa']))
                    ->canSee(fn() => auth()->user()->hasPermissionTo('change_language')),

                MenuItem::externalLink(__("Change Application Language", ['lang' => trans("Arabic")]), route("app.setting.language", ['file' => 'ar']))
                    ->canSee(fn() => auth()->user()->hasPermissionTo('change_language')),

            ])->icon('fas fa-toolbox fa-2x')->collapsable()->collapsedByDefault(),
            MenuSection::dashboard(EducationalVideo::class)->icon('fab fa-youtube fa-2x'),

        ]);

        Nova::footer(fn($request) => "Powered By MOD");
    }


    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
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
            new EducationalVideo,
            new OilDistribution,
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

            (new PriceTracker)->canSee(fn() => auth()->user()->hasRole('super-admin')),
            (new GuestReport)->canSee(fn() => auth()->user()->hasRole('super-admin')),
            (new OilReport())->canSee(fn() => auth()->user()->hasRole('super-admin')),
        ];
    }
    public function register(): void
    {
        //
    }
}
