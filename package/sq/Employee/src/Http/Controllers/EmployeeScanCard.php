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

        // get the code from request
        $code = $request->input("code");

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
            Attendance::updateOrCreate(
                [
                    'card_info_id' => $employee->id,
                    'date' => now()->format('Y-m-d'),
                ],
                [
                    'gate_id' => auth()->user()->gate->id,
                ]
            );
            $attendance = [

                // IF enter is null and state not absent
                'present' => is_null($employee->today_attendance?->enter) && $employee->today_attendance?->state != 'U',

                // IF enter is not Null and State not absent
                'exit' => $employee->today_attendance?->enter && is_null($employee->today_attendance?->exit) && $employee->today_attendance?->state != "U",

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

            // Create a new instance
            $today_attendance = Attendance::updateOrCreate(
                [
                    'card_info_id' => $cardInfo->id,
                    'date' => now()->format('Y-m-d'),
                ],
                [
                    'gate_id' => $gate->id,
                ]
            );

            // if employee not absent
            if ($today_attendance->state != "U") {

                // If employee Not absent and the state is enter
                if ($state == 'enter') {

                    // Fill the date to NOW
                    $today_attendance->enter = now();

                    // State changed to P - Present
                    $today_attendance->state = "P";

                    // else If employee Present and the state is enter and not absent then fill exit to now
                } elseif ($today_attendance->enter && $state == 'exit') {

                    // Update Attendance Datetime to NOW
                    $today_attendance->exit = now();
                }
                // Save the instance
                $today_attendance->save();
            }
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
                        'end' => Carbon::now()->between($context['end']['0'], $context['end']['1'])
                    ]
                )
            ])
            ->then(destination: fn($context): mixed => $context);
    }

}
