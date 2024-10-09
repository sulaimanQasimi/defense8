<?php

namespace Sq\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
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
        //
        $guest = null;
        //
        $code = $request->input("code");
        //
        if (\Illuminate\Support\Str::startsWith($code, 'Guest-')) {
            $guest = Guest::query()->where('barcode', $code)->first();
        }
        //
        $employee = CardInfo::query()->where('registare_no', "=", $code)->first();
        if ($employee) {
            ScanedEmployee::create(attributes: [
                'card_info_id' => $employee->id,
                'gate_id' => auth()->user()?->gate?->id,
                'scaned_at' => now(),
            ]);
        }
        //
        return view("sqemployee::employee.scan", compact("employee", "code", 'guest'));
    }



    public function employeeState(Request $request, CardInfo $cardInfo)
    {

        $this->authorize('gatePass', $cardInfo);

        // Get Current Gate
        $state = $request->input('state');

        // Get User Gate
        $gate = auth()->user()->gate;

        // If user have ability to Gate Checker
        $this->authorize('gateChecker', $gate);


        // Get wheather  enter or Exit

        if ((in_array(needle: $cardInfo?->gate->id, haystack: UserDepartment::getUserGate())) && !is_null($state)) {

            $today_attendance =
                Attendance::updateOrCreate(
                    [
                        'gate_id' => $gate->id,
                        'card_info_id' => $cardInfo->id,
                        'date' => now()->format('Y-m-d'),
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

    public function scan_other_website_employee(Request $request)
    {

    }

}
