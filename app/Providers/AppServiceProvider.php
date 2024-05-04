<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Faculty;
use App\Observers\AttendanceObserver;
use App\Observers\DepartmentObserver;
use App\Observers\FacultyObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Department::observe(DepartmentObserver::class);
        Attendance::observe(AttendanceObserver::class);
    }
}
