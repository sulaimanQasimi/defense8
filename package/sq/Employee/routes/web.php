<?php
use Illuminate\Support\Facades\Route;
use Sq\Employee\Http\Controllers\CurrentMonthEmployeeAttendance;
use Sq\Employee\Http\Controllers\EmployeeInfoPDF;
use Sq\Employee\Http\Controllers\EmployeeScanCard;
use Sq\Employee\Http\Controllers\ExcelEmployeeExportController;
use Sq\Employee\Livewire\Attendance;
use Sq\Employee\Livewire\Department\SetAttendance;

Route::middleware(["guestGatePassed", 'can:gateChecker,\Sq\Employee\Models\Gate'])
    ->controller(EmployeeScanCard::class)
    ->name('employee.check.')
    ->group(function () {
        // Self Website Check
        Route::get('employee', 'scan')->name('card');
        Route::get('passemployee/{cardInfo:id}/to', 'employeeState')->name('pass');

        // Other Orginization
        Route::middleware(['permission:see-other-website-data'])
            ->get('other', 'scan_other_website_employee')
            ->name('other-website-employee');
    });

// Other Website Employees Check
Route::middleware(['permission:see-other-website-data'])
    ->get('other-websites', [EmployeeScanCard::class, 'scan_other_website_employee'])
    ->name('check.other-website-employee');


Route::middleware(['role:super-admin'])
    ->get("attend", Attendance::class)
    ->name("employee.attendance.check");

Route::middleware(['can:admin,department', 'permission:check own department attendance'])
    ->get("attendance/{department:id?}", SetAttendance::class)
    ->name("department.employee.attendance.check");

// Route::middleware(['role:super-admin'])
//     ->get('employee/attendance/current/month', CurrentMonthEmployeeAttendance::class)
//     ->name("employee.attendance.current.month");

Route::middleware(['role:super-admin'])
    ->get('employee/attendance/current/month/employee/{cardInfo:id}', [CurrentMonthEmployeeAttendance::class, 'single_employee'])
    ->name("employee.attendance.current.month.single");

Route::middleware(['role:super-admin'])
    ->get('employee/attendance/current/month/department/{department:id}', [CurrentMonthEmployeeAttendance::class, 'single_department'])
    ->name("employee.attendance.current.month.department.single");

Route::prefix('export/')
    ->name('export.excel.')
    ->controller(ExcelEmployeeExportController::class)
    ->group(function () {
        Route::middleware(['can:admin,department'])->get('attendance/{department:id}', 'attendance')->name('attendance');
    });

Route::prefix("employee/")
    ->controller(EmployeeInfoPDF::class)
    ->group(function () {
        Route::get('{cardInfo:id}/personal/info', 'info')
            ->name("employee.personal.info");

        Route::get('department/{department:id}/personal/info', 'department')
            ->name("department.employee.personal.info");
    });


//
