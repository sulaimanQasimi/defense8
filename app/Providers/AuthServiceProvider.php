<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Sq\Employee\Models\Department;
use App\Models\Finance\AccountingAdministrationIncome;
use App\Models\Finance as FinaceModel;
use App\Policies\ActivityPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\Finance as FinacePolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Spatie\Activitylog\Models\Activity;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Finance Policy
        Activity::class=>ActivityPolicy::class,
        // Department::class=>DepartmentPolicy::class,


    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
//
    }
}
