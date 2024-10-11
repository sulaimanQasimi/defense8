<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Laravel\Nova\Notifications\NovaNotification;
use Sq\Employee\Jobs\ApsentAndExitedEmployeeAttendance;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('telescope:prune --hours=48')->dailyAt("23:00");
        // $schedule->command('backup:run --only-db')->dailyAt("21:30");
        // $schedule->command('backup:run --only-db')->everyTenSeconds();
        //
        $schedule->call(function () {
            foreach (User::all() as $user) {
                $user->notify(
                    NovaNotification::make()
                        ->message(trans("Good Morning Sir."))
                        ->type('info')
                );
            }
        })->dailyAt("09:00");
        $schedule->job(new ApsentAndExitedEmployeeAttendance())->everyFiveSeconds();


        // $schedule->command('telescope:prune')->dailyAt("08:30");
        // $schedule->command('backup:clean')->everyMinute();
        // $schedule->command('view:clear')->everyMinute();
        // $schedule->exec('npm run build')->everyMinute();
        // $schedule->exec('npm run build')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
