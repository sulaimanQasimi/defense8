<?php

namespace App\Providers;

use App\Nova\Card\CardInfo as CardCardInfo;
use App\Nova\CardInfo;
use App\Nova\Dashboards\Main;
use App\Nova\Department;
use App\Nova\Gate;
use App\Nova\Guest;
use App\Nova\GuestOption;
use App\Nova\Host;
use App\Nova\PrintCardFrame;
use App\Nova\User;
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
        Nova::enableRTL();
        Nova::mainMenu(fn(Request $request) => [
            MenuSection::dashboard(Main::class)->icon('chart-bar'),
            MenuSection::make(__('Guest'), [
                MenuItem::resource(Host::class),
                MenuItem::resource(Gate::class),
                MenuItem::resource(Guest::class),
                MenuSection::make(__('Guest Report'), [
                    MenuItem::externalLink(__("Daily Guest Report"), route("guest.report.daily"))->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),

                    MenuItem::externalLink(__("Weekly Guest Report"), route("guest.report.weekly"))->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),

                    MenuItem::externalLink(__("Monthly Guest Report"), route("guest.report.monthly"))->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),

                    MenuItem::externalLink(__("Yearly Guest Report"), route("guest.report.yearly"))->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),


                ])->collapsable()->collapsedByDefault()->icon('document'),

            ])->collapsable()->collapsedByDefault()->icon('user-group'),


            MenuSection::make(__('Card'), [
                MenuItem::resource(Department::class),
                MenuItem::resource(CardCardInfo::class),
                MenuItem::externalLink(__("Employee Check Card"), route("employee.check.card"))
                    ->canSee(fn() => auth()->user()->gate),
                MenuItem::externalLink(
                    __("Employee Attendance Check Self Department"),
                    route(
                        "department.employee.attendance.check",
                        ['department' => auth()->user()?->department]
                    )
                )
                    ->canSee(fn() => auth()->user()->department),
                MenuItem::externalLink(__("Employee Attendance Check Department"), route("employee.attendance.check"))
                    ->canSee(fn() => auth()->user()->hasRole('super-admin')),

                // MenuItem::externalLink(__("Download CURRENT MONTH ATTENDANCE EMPLOYEE"), route("employee.attendance.current.month"))
                //     ->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),

                MenuItem::externalLink(__("ATTENDANCE EMPLOYEE Report Generator"), route("employee.attendance.pdf.generator"))
                    ->canSee(fn() => auth()->user()->hasRole('super-admin'))->openInNewTab(),


            ])->collapsable()
                ->collapsedByDefault(),


            MenuSection::make(__('Administration'), [
                MenuItem::resource(PrintCardFrame::class),
                MenuItem::resource(GuestOption::class),
                MenuItem::resource(Permission::class),
                MenuItem::resource(Role::class),
                MenuItem::resource(User::class),
                MenuItem::resource(Activitylog::class)->canSee(fn() => auth()->user()->hasRole('super-admin')),
                MenuItem::resource(Website::class)->canSee(fn() => auth()->user()->hasRole('super-admin')),
                MenuItem::externalLink(__("See Other Website Data"), route("check.other-website-employee"))
                    ->canSee(fn() => auth()->user()->hasPermissionTo('see-other-website-data'))
                    ->openInNewTab(),
                MenuItem::externalLink(__("Create Token"), url("user/api-tokens"))
                    ->canSee(fn() => auth()->user()->hasRole('api-token'))->openInNewTab(),
            ])
                ->icon('cog')->collapsable()->collapsedByDefault(),


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
        ];
    }

    public function tools()
    {
        return [

            new \Sereny\NovaPermissions\NovaPermissions(),
            new \Bolechen\NovaActivitylog\NovaActivitylog(),
            // new \GeneaLabs\NovaPassportManager\NovaPassportManager,
        ];
    }
    public function register(): void
    {
        //
    }
}
