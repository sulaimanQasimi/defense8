<?php
use App\Support\Defense\PermissionTranslation;
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
    });

Route::middleware(['role:super-admin'])
    ->get("attend", Attendance::class)
    ->name("employee.attendance.check");

Route::middleware(['can:admin,department', 'permission:check own department attendance'])
    ->get("attendance/{department:id?}", SetAttendance::class)
    ->name("department.employee.attendance.check");

Route::middleware(['role:super-admin'])
    ->get(
        'employee/attendance/current/month/employee/{cardInfo:id}',
        [CurrentMonthEmployeeAttendance::class, 'single_employee']
    )
    ->name("employee.attendance.current.month.single");


// Custom Month Department Attendance in Excel Format

Route::prefix('export/')
    ->name('export.excel.')
    ->controller(ExcelEmployeeExportController::class)
    ->group(function () {
        Route::middleware(['can:admin,department'])->get('attendance/{department:id}', 'attendance')->name('attendance');
    });

Route::prefix("employee/")
    ->controller(EmployeeInfoPDF::class)
    // ->name('report.')
    ->group(function () {
        Route::get('{cardInfo:id}/personal/info', 'info')
            ->name("employee.personal.info");

        Route::get('department/{department:id}/personal/info', 'department')
            ->name("department.employee.personal.info");
    });

//
Route::middleware(['permission:' . PermissionTranslation::viewAny("Card Info")])
    ->group(function () {


        // Current Month Department Attendance in PDF Format

        Route::get(
            'employee/attendance/current/month/department/{department:id}',
            [CurrentMonthEmployeeAttendance::class, 'single_department']
        )
            ->name("employee.attendance.current.month.department.single");


        // Current Month Department Attendance in Excel Format
        Route::get(
            'employee/attendance/current/month/department/{department:id}/excel',
            [ExcelEmployeeExportController::class, 'attendance']
        )
            ->name("employee.attendance.current.month.department.single.excel");


    });

// BioData routes
Route::prefix('employee/biodata')
    ->middleware(['permission:' . PermissionTranslation::update("Card Info")])
    ->controller(\Sq\Employee\Http\Controllers\BioDataController::class)
    ->name('employee.biodata.')
    ->group(function (): void {
        Route::get('{employee_id}', 'show')->name('show');
        Route::post('{employee_id}', 'store')->name('store');
        Route::delete('{employee_id}', 'destroy')->name('destroy');
        Route::post('{employee_id}/verify', 'verify')->name('verify');
    });

// Fingerprint match routes - identify employees using fingerprints
Route::prefix('employee/finger')
    ->middleware(['permission:' . PermissionTranslation::viewAny("Card Info")])
    ->controller(\Sq\Employee\Http\Controllers\FingerMatchController::class)
    ->name('employee.finger.')
    ->group(function (): void {
        Route::get('match', 'index')->name('index');
        Route::post('match', 'match')->name('match');
    });
