<?php

namespace Sq\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Benchmark;
use \Sq\Employee\Http\Controllers\Contracts\Attendance;
use Sq\Guest\Models\Guest;
use Illuminate\Http\Request;
use Sq\Guest\Models\Patient;
use Sq\Guest\Models\PatientGatePass;

class EmployeeScanCard extends Controller
{
    public function scan(Request $request)
    {
        //
        $guest = null;
        $patient = null;

        // get the code from request
        $code = $request->input("code");

        // if the guest code scaned
        if (\Illuminate\Support\Str::startsWith(haystack: $code, needles: 'Guest-')) {
            $guest = Guest::query()->where('barcode', $code)
                ->first();
            if ($guest->host?->department_id) {
            }
        }
        // if the guest code scaned
        if (\Illuminate\Support\Str::startsWith(haystack: $code, needles: 'Patient-')) {
            $patient = Patient::query()->where('barcode', $code)
                ->first();
            // Check if patient already has a gate_id and it's different from the current user's gate
            if ($patient->gate_id == auth()->user()->gate_id) {
                PatientGatePass::create([
                    'patient_id' => $patient->id,
                    'gate_id' => auth()->user()->gate_id,
                    'entered_at' => now(),
                ]);

            }
        }
        $attendance = new Attendance($code);

        return view("sqemployee::employee.scan", data: [
            'employee' => $attendance->employee,
            'guest' => $guest,
            'patient' => $patient,
            'attendance' => $attendance->proform_attendance()
        ]);
    }
}
