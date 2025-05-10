<?php
namespace Sq\Employee;

use App\Support\Defense\PermissionTranslation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Livewire\Livewire;
use Sq\Employee\Nova as NovaResource;
use Sq\Employee\Nova\ScanedEmployee;
use Sq\Employee\Nova\Lenses\MainCardExpireToday;

class EmployeeServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Livewire::component('sq.employee.livewire.attendance', \Sq\Employee\Livewire\Attendance::class);
        Livewire::component(
            'sq-employee-set-employee-attendance',
            \Sq\Employee\Livewire\Department\SetEmployeeAttendanceState::class
        );
        Nova::resources([
            NovaResource\Attendance::class,
            NovaResource\CardInfo::class,
            ScanedEmployee::class,
            NovaResource\Department::class,
            NovaResource\EmployeeVehicalCard::class,
            NovaResource\Gate::class,
            NovaResource\GunCard::class,
            NovaResource\MainCard::class,
        ]);


        $this->loadMigrationsFrom(__DIR__ . "/../database/migrations");
        $this->loadViewsFrom(__DIR__ . "/../resources/views/", 'sqemployee');
        Route::group(attributes: $this->routeConfiguration(), routes: function (): void {
            $this->loadRoutesFrom(__DIR__ . "/../routes/web.php");
        });
        $this->loadRoutesFrom(__DIR__ . "/../routes/api.php");
        $this->loadJsonTranslationsFrom(__DIR__ . "/../langs/");

    }
    public function register()
    {
        $this->app->singleton(\Sq\Employee\Services\FingerprintService::class, function ($app) {
            return new \Sq\Employee\Services\FingerprintService();
        });
    }
    public function routes()
    {

    }
    public static function registerMenu(): MenuSection
    {
        return
            // Card and Employee Section
            MenuSection::make(__('Employees'), [

                // Department Menu Item
                MenuItem::resource(resourceClass: NovaResource\Department::class),

                // Gate Menu Item
                MenuItem::resource(resourceClass: NovaResource\Gate::class),


                // Employee Menu Item
                MenuItem::resource(resourceClass: NovaResource\CardInfo::class),

                MenuItem::resource(\Sq\Employee\Nova\MainCard::class),


                // Employee Menu Item
                MenuItem::resource(resourceClass: NovaResource\EmployeeVehicalCard::class),

                // Employee Menu Item
                MenuItem::resource(resourceClass: NovaResource\GunCard::class),

                MenuItem::resource(\Sq\Card\Nova\PrintCardFrame::class),
                MenuItem::resource(\Sq\Card\Nova\CustomPaperCard::class),
                MenuItem::resource(\Sq\Card\Nova\PrintCard::class),

                MenuItem::resource(resourceClass: NovaResource\Attendance::class),
                //
                MenuItem::resource(resourceClass: NovaResource\ScanedEmployee::class),

                // Employee Check out Page
                MenuItem::externalLink('گزارش کارت چاپ شده', route("sq.card.reports.printed"))
                    ->canSee(fn() => auth()->user()->hasPermissionTo('printed-card-view')),
            // Employee Check out Page
            MenuItem::externalLink(__("Employee Check Card"), route("sqemployee.employee.check.card"))
            ->canSee(fn() => \Illuminate\Support\Facades\Gate::allows('gateChecker', \Sq\Employee\Models\Gate::class)),

                // Fingerprint Identification
                MenuItem::externalLink(__("Fingerprint Identification"), route("sqemployee.employee.finger.index"))
                    ->canSee(fn() => auth()->user()->hasPermissionTo(PermissionTranslation::viewAny("Card Info"))),

                // Biometric CardInfo Matching
                MenuItem::externalLink(__("Biometric Card Identification"), route("fingerprint.cardinfo.index"))
                    ->canSee(fn() => auth()->user()->hasPermissionTo(PermissionTranslation::viewAny("Card Info"))),

                // Self Employee Attendance
                MenuItem::externalLink(
                    __("Employee Attendance Check Self Department"),
                    route(
                        "sqemployee.department.employee.attendance.check",
                        ['department' => auth()->user()?->department]
                    )
                )->canSee(fn() => auth()->user()->hasPermissionTo('check own department attendance')),

                // Check Attendance of Department
                MenuItem::externalLink(__("Employee Attendance Check Department"), route("sqemployee.employee.attendance.check"))
                    ->canSee(fn() => auth()->user()->hasRole('super-admin')),

                // Report Generator of Attendance
                MenuItem::link(__("ATTENDANCE EMPLOYEE Report Generator"), 'price-tracker')
                    ->canSee(fn() => auth()->user()->hasPermissionTo(PermissionTranslation::viewAny("Card Info"))),

                // Frame of Printable Card Menu Item


            ])
                ->collapsable()
                ->collapsedByDefault()
                ->icon("fas fa-users-rectangle fa-2x");
    }

    protected function routeConfiguration()
    {
        return [
            // 'domain' => config('nova.domain', null),
            'as' => 'sqemployee.',
            'prefix' => 'sq/modules/employee',
            'middleware' => ['web', 'auth'],

        ];
    }
}
