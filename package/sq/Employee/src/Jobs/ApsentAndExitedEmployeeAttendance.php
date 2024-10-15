<?php

namespace Sq\Employee\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sq\Employee\Models\Attendance;
use Sq\Employee\Models\CardInfo;

class ApsentAndExitedEmployeeAttendance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        // Exit All Employee if exit column is null
        CardInfo::query()
            ->whereHas(relation: 'today_attendance_present_not_exit')
            ->with(relations: ['today_attendance_present_not_exit'])
            ->get()
            ->each(callback: function ($employee) {
                $employee->today_attendance_present_not_exit()
                    ->update(['exit' => now()]);
            });


        // IF the employee doesnt have attendance than Create attendant with absent state
        CardInfo::query()
            ->whereDoesntHave(relation: 'today_attendance')
            ->with(relations: ['today_attendance'])
            ->get()
            ->each(callback: function ($employee) {
                Attendance::updateOrCreate(
                    [
                        'card_info_id' => $employee->id,
                        'date' => now()->format('Y-m-d'),

                    ],
                    [
                        'gate_id' => $employee->gate?->id,
                        'time' => now(),
                        'state' => "U"
                    ]
                );
            }); // IF the employee doesnt have attendance than Create attendant with absent state
            CardInfo::query()
                ->whereHas(relation: 'today_attendance_not_present_exit')
                ->with(relations: ['today_attendance'])
                ->get()
                ->each(callback: function ($employee) {
                    Attendance::updateOrCreate(
                        [
                            'card_info_id' => $employee->id,
                            'date' => now()->format('Y-m-d'),
                        ],
                        [
                            'gate_id' => $employee->gate?->id,
                            'time' => now(),
                            'state' => "U"
                        ]
                    );
                });

    }
}
