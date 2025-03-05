<?php

namespace Sq\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Benchmark;
use \Sq\Employee\Http\Controllers\Contracts\Attendance;
use Sq\Guest\Models\Guest;
use Illuminate\Http\Request;
class EmployeeScanCard extends Controller
{
    public function scan(Request $request)
    {
        //
        $guest = null;

        // get the code from request
        $code = $request->input("code");

        // if the guest code scaned
        if (\Illuminate\Support\Str::startsWith(haystack: $code, needles: 'Guest-')) {
            $guest = Guest::query()->where('barcode', $code)
            ->first();
            if($guest->host?->department_id){

            }
        }
        $attendance= new Attendance($code);

        return view("sqemployee::employee.scan", data: [
            'employee' => $attendance->employee,
            'guest' => $guest,
            'attendance' => $attendance->proform_attendance()
        ]);
    }
}
