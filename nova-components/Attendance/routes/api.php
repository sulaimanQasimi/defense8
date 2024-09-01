<?php

use App\Http\Resources\EmployeeAttenceResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Sq\Employee\Models\Attendance;
use Sq\Employee\Models\CardInfo as Employee;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/', function (Request $request) {
    $department = auth()->user()->department;
    $employees =  EmployeeAttenceResource::collection(
        Employee::where('department_id', $department->id)
        ->orderBy('name')
        ->paginate(21));
    return [
        'employees' => $employees,
        'department' => $department
    ];
});
Route::get('/save', function (Request $request) {
    $employee = $request->input('employee');
    $state = $request->input('state');


    $employeeModel = Employee::find($employee);

    if ($employee && $state && $employeeModel) {
        $todayAttendance = Attendance::updateOrCreate(
            [
                'gate_id' => $employeeModel->gate->id,
                'card_info_id' => $employeeModel->id,
                'date' => now()->format('Y-m-d'),
            ]
        );

        // Present Employee
        if ($todayAttendance->state != "U" && $state == 'enter') {
            // Set Enter Time
            $todayAttendance->enter = now();
            // Mark as Present
            $todayAttendance->state = "P";

            // Exit Employee
        } elseif ($todayAttendance->enter && $todayAttendance->state != "U" && $state == 'exit') {
            // Set Exit time
            $todayAttendance->exit = now();

            // Upsent Employee
        } elseif ($todayAttendance->state != "P" && $state == 'upsent') {
            // Mark as absent
            $todayAttendance->state = "U";
        }

        // Save the Model
        $todayAttendance->save();
    }
});
