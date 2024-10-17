<?php

namespace Sq\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use \Sq\Employee\Http\Controllers\Contracts\Attendance;
use Sq\Guest\Models\Guest;
use Illuminate\Http\Request;
use Sq\Query\Policy\UserDepartment;

class EmployeeScanCard extends Controller
{
    public function scan(Request $request)
    {
        //
        $guest = null;

        // get the code from request
        $code = $request->input("code");


        // if the guest code scaned
        if (\Illuminate\Support\Str::startsWith($code, 'Guest-')) {
            $guest = Guest::query()->where('barcode', $code)->first();
        }
        $attendance= new Attendance($code);

        return view("sqemployee::employee.scan", data: [
            'employee' => $attendance->employee,
            'guest' => $guest,
            'code' => $code,
            'attendance' => $attendance->proform_attendance()
        ]);
    }
}
