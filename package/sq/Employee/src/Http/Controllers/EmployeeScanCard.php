<?php

namespace Sq\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Settings\AttendanceTimer;
use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Pipeline;
use Sq\Employee\Models\Attendance;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\ScanedEmployee;
use Sq\Guest\Models\Guest;
use Illuminate\Http\Request;
use Sq\Query\Policy\UserDepartment;

class EmployeeScanCard extends Controller
{
    public function scan(Request $request)
    {
        $date = self::attendance_timer();
        //
        $guest = null;

        // get the code from request
        $code = $request->input("code");
        $state = null;
        $attendance = null;

        // if the guest code scaned
        if (\Illuminate\Support\Str::startsWith($code, 'Guest-')) {
            $guest = Guest::query()->where('barcode', $code)->first();
        }
        //
        $employee = CardInfo::query()

            // Preload Relationships
            ->with(['employeeOptions', 'employee_vehical_card', 'gun_card'])
            // Find Current Employee

            ->where('registare_no', "=", $code)

            // Get First Record
            ->first();

        // Create Scaned Record
        if ($employee) {
            ScanedEmployee::create(attributes: [
                'card_info_id' => $employee->id,
                'gate_id' => auth()->user()?->gate?->id,
                'scaned_at' => now(),
            ]);

            // Create a new instance
            $attendance = Attendance::updateOrCreate(
                [
                    'card_info_id' => $employee->id,
                    'date' => now()->format('Y-m-d'),
                ],
                [
                    'gate_id' => auth()->user()->gate->id,
                ]
            );
            //  If Gate Related to this employee gate
            if (in_array($employee?->gate?->id, UserDepartment::getUserGate())) {

                // Present
                if ($date['start'] && is_null($employee->today_attendance?->enter) && $employee->today_attendance?->state != 'U') {

                    // Fill the date to NOW
                    $attendance->enter = now();

                    // State changed to P - Present
                    $attendance->state = "P";
                }
                // exit
                if ($date['end'] && $employee->today_attendance?->enter && is_null($employee->today_attendance?->exit) && $employee->today_attendance?->state != "U") {

                    // Update Attendance Datetime to NOW
                    $attendance->exit = now();
                }
                $attendance->save();
                $attendance->fresh();
                $state = $attendance->state;
            }

        }
        //
        return view("sqemployee::employee.scan", compact("employee", "code", 'guest', 'attendance'));
    }

    public static function attendance_timer()
    {

        return Pipeline::send(passable: new AttendanceTimer)
            ->through(pipes: [
                fn($context, Closure $next): mixed => $next(['start' => $context->start, 'end' => $context->end]),
                fn($context, Closure $next): mixed => $next(['start' => mb_split(pattern: ' ', string: $context['start']), 'end' => mb_split(' ', $context['end'])]),
                fn($context, Closure $next): mixed => $next(
                    [
                        'start' =>
                            [
                                Carbon::make(var: $context['start'][0]),
                                Carbon::make(var: $context['start'][1])
                            ],
                        'end' => [
                            Carbon::make(var: $context['end'][0])->addHours(value: 12),
                            Carbon::make(var: $context['end'][1])->addHours(value: 12)
                        ]
                    ]
                ),
                fn($context, Closure $next): mixed => $next(
                    [
                        'start' => Carbon::now()->between($context['start']['0'], $context['start']['1']),
                        'end' => Carbon::now()->between($context['end']['0'], $context['end']['1'])
                    ]
                )
            ])
            ->then(destination: fn($context): mixed => $context);
    }
}
