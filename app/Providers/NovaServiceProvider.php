<?php

namespace App\Providers;

use App\Nova\Card\CardInfo as CardCardInfo;
use App\Nova\Card\EmployeeVehicalCard;
use App\Nova\Card\GunCard;
use App\Nova\CardInfo;
use App\Nova\Dashboards\GraphDashboard;
use App\Nova\Dashboards\Main;
use App\Nova\Department;
use App\Nova\District;
use App\Nova\Gate;
use App\Nova\Guest;
use App\Nova\GuestOption;
use App\Nova\Host;
use App\Nova\PrintCardFrame;
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

            ])->collapsable()
                ->collapsedByDefault()
                ->icon('fas fa-person-shelter fa-2x'),

            // Guest Report Menu Section
            MenuSection::make(__('Guest Report'), [

                // Daily Guest Report Menu Item
                MenuItem::externalLink(__("Daily Guest Report"), route("guest.report.daily"))->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),

                // Weekly Guest Report Menu Item
                MenuItem::externalLink(__("Weekly Guest Report"), route("guest.report.weekly"))->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),

                // Monthly Guest Report Menu Item
                MenuItem::externalLink(__("Monthly Guest Report"), route("guest.report.monthly"))->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),

                // Yearly Guest Report Menu Item
                MenuItem::externalLink(__("Yearly Guest Report"), route("guest.report.yearly"))->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),

            ])->collapsable()->collapsedByDefault()->icon('fas fa-file-signature fa-2x'),

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
                MenuItem::externalLink(__("Employee Check Card"), route("employee.check.card"))->canSee(fn() => \Illuminate\Support\Facades\Gate::allows('gateChecker', \App\Models\Gate::class)),

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

                // MenuItem::externalLink(__("Download CURRENT MONTH ATTENDANCE EMPLOYEE"), route("employee.attendance.current.month"))
                //     ->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),

                // Report Generator of Attendance
                MenuItem::externalLink(__("ATTENDANCE EMPLOYEE Report Generator"), route("employee.attendance.pdf.generator"))->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),

                // Frame of Printable Card Menu Item
                MenuItem::resource(PrintCardFrame::class),


            ])->collapsable()->collapsedByDefault()->icon("fas fa-users-rectangle fa-2x"),

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
            new GraphDashboard
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
        ];
    }
    public function register(): void
    {
        //
    }
}
