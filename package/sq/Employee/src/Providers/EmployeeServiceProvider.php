<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EmployeeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\Sq\Employee\Services\FingerprintService::class, function ($app) {
            return new \Sq\Employee\Services\FingerprintService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(/* Add any necessary dependencies here */)
    {
        //
    }
}
