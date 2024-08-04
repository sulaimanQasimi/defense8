<?php

namespace App\Observers;

use Sq\Employee\Models\Department;
use Laravel\Nova\Notifications\NovaNotification;

class DepartmentObserver
{
    /**
     * Handle the Department "created" event.
     */
    public function created(Department $department): void
    {
        //
    }

    /**
     * Handle the Department "updated" event.
     */
    public function updated(Department $department): void
    {
        request()->user()->notify(
            NovaNotification::make()
                ->message(trans("The :resource was updated!",['resource'=>trans('Department')]))
                ->type('info')
        );
            }

    /**
     * Handle the Department "deleted" event.
     */
    public function deleted(Department $department): void
    {

    }

    /**
     * Handle the Department "restored" event.
     */
    public function restored(Department $department): void
    {
        //
    }

    /**
     * Handle the Department "force deleted" event.
     */
    public function forceDeleted(Department $department): void
    {
        //
    }
}
