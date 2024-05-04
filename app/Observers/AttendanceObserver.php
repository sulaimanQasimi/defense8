<?php

namespace App\Observers;

use App\Models\Attendance;
use Laravel\Nova\Notifications\NovaNotification;

class AttendanceObserver
{
    /**
     * Handle the Attendance "created" event.
     */
    public function created(Attendance $attendance): void
    {
        //
    }

    /**
     * Handle the Attendance "updated" event.
     */
    public function updated(Attendance $attendance): void
    {
        if ($attendance->state == 'U') {
            request()->user()->notify(
                NovaNotification::make()
                    ->message(trans("Employee Marked Upsent"))
                    ->type('info')
            );
        }
        if ($attendance->state == 'P') {
            request()->user()->notify(
                NovaNotification::make()
                    ->message(trans("Employee Marked Present"))
                    ->type('info')
            );
        }
    }

    /**
     * Handle the Attendance "deleted" event.
     */
    public function deleted(Attendance $attendance): void
    {
        //
    }

    /**
     * Handle the Attendance "restored" event.
     */
    public function restored(Attendance $attendance): void
    {
        //
    }

    /**
     * Handle the Attendance "force deleted" event.
     */
    public function forceDeleted(Attendance $attendance): void
    {
        //
    }
}
