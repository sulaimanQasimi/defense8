<?php

namespace Sq\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Settings\AttendanceTimer;
use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Pipeline;
use Sq\Employee\Models\Attendance;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\MainCard;
use Sq\Employee\Models\ScanedEmployee;
use Sq\Guest\Models\Guest;
use Sq\Employee\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Sq\Query\Policy\UserDepartment;

class EmployeeScanCard extends Controller
{
    public function scan(Request $request)
    {
        $date = self::attendance_timer();
        $attendance = [];
        //
        $guest = null;

        //
        $code = $request->input("code");

        //
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

            $attendance = [
                'present' => !$employee->current_gate_attendance?->enter && $employee->current_gate_attendance?->state != 'U',
                'exit' => !is_null($employee->current_gate_attendance?->enter) && is_null($employee->current_gate_attendance?->exit) && $employee->current_gate_attendance?->state != "U",
                'absent' => $employee->current_gate_attendance?->state != 'P' && is_null($employee->current_gate_attendance?->state),

                'allowed_gate' => in_array($employee?->gate?->id, UserDepartment::getUserGate())
            ];
        }

        //
        return view("sqemployee::employee.scan", compact("employee", "code", 'guest', 'date', 'attendance'));
    }



    public function employeeState(Request $request, CardInfo $cardInfo)
    {

        $this->authorize(ability: 'gatePass', arguments: $cardInfo);

        // Get Current Gate
        $state = $request->input('state');

        // Get User Gate
        $gate = auth()->user()->gate;

        // If user have ability to Gate Checker
        $this->authorize(ability: 'gateChecker', arguments: $gate);


        // Get wheather  enter or Exit

        if ((in_array(needle: $cardInfo?->gate->id, haystack: UserDepartment::getUserGate())) && !is_null($state)) {

            $today_attendance = Attendance::updateOrCreate(
                [
                    'card_info_id' => $cardInfo->id,
                    'date' => now()->format('Y-m-d'),
                ],
                [
                    'gate_id' => $gate->id,
                ]
            );

            // If employee Not absent and the state is enter
            if ($today_attendance->state != "U" && $state == 'enter') {

                // Fill the date to NOW
                $today_attendance->enter = now();

                // State changed to P - Present
                $today_attendance->state = "P";

                // else If employee Present and the state is enter and not absent then fill exit to now
            } elseif ($today_attendance->enter && $today_attendance->state != "U" && $state == 'exit') {

                // Update Attendance Datetime to NOW
                $today_attendance->exit = now();

            } elseif ($today_attendance->state != "P" && $state == 'upsent') {

                // State changed to U - Absent
                $today_attendance->state = "U";
            }

            $today_attendance->save();

        } else {
            return abort(403);
        }
        return redirect()->route("sqemployee.employee.check.card");
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
                        // 2:10 < 1:20 &&
                        'end' => Carbon::now()->between($context['end']['0'], $context['end']['1'])
                    ]
                )
            ])
            ->then(destination: fn($context): mixed => $context);
    }

}
