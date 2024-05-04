<?php

use App\Http\Controllers\CurrentMonthEmployeeAttendance;
use App\Http\Controllers\Employee\PrintCardController;
use App\Http\Controllers\EmployeeInfoPDF;
use App\Http\Controllers\EmployeeScanCard;
use App\Http\Controllers\ExcelEmployeeExportController;
use App\Http\Controllers\Guest\QRCodeGenerateController;
use App\Http\Controllers\Report\DailyGuestsReport;
use App\Livewire\AttendanceGenerator;
use App\Livewire\CardDesign;
use App\Models\Attendance;
use App\Models\Card\CardInfo;
use App\Models\Website;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Lottery;
use Illuminate\Support\Sleep;

Route::middleware('auth')->get(
    'generate',
    fn() => view('guest.generateQR')
);
Route::prefix("guest")
    ->controller(QRCodeGenerateController::class)
    ->group(function () {
        Route::middleware(['auth', "guestGatePassed"])->get('passguest/{guest:id}/to', 'state')->name('guest.check');
        Route::middleware(['auth', "guestGatePassed"])->get('passemployee/{cardInfo:id}/to', 'employeeState')->name('employee.check');
        Route::middleware('auth')->get('/generate/{guest:id}', 'generate')->name('guest.generate');
    });

Route::middleware(['auth', "guestGatePassed"])
    ->controller(EmployeeScanCard::class)->group(function () {
        Route::get('employee', 'scan')->name('employee.check.card');
        Route::get('other', 'scan_other_website_employee')
            ->name('employee.check.other-website-employee');
    });

Route::middleware(['auth', 'permission:see-other-website-data',])
    ->get('other-websites', (new EmployeeScanCard())->scan_other_website_employee(...))
    ->name('check.other-website-employee');



Route::middleware(['auth', 'role:super-admin'])->prefix('report/guest/')->name('guest.report.')->group(function () {
    Route::get('daily', DailyGuestsReport::class)->name('daily');
    Route::get('monthy', \App\Http\Controllers\Report\MonthlyGuestsReport::class)->name('monthly');
    Route::get('weekly', \App\Http\Controllers\Report\WeeklyGuestsReport::class)->name('weekly');
    Route::get('yearly', \App\Http\Controllers\Report\YearlyGuestsReport::class)->name('yearly');
});
Route::middleware(['auth'])->group(function () {
    Route::get("attend", \App\Livewire\Attendance::class)->name("employee.attendance.check");
    Route::get("attendance/{department:id?}", \App\Livewire\Department\SetAttendance::class)->name("department.employee.attendance.check");
    Route::get('employee/attendance/current/month', CurrentMonthEmployeeAttendance::class)->name("employee.attendance.current.month");
    Route::get('employee/attendance/current/month/employee/{cardInfo:id}', [CurrentMonthEmployeeAttendance::class, 'single_employee'])->name("employee.attendance.current.month.single");
    Route::get('employee/attendance/current/month/department/{department:id}', [CurrentMonthEmployeeAttendance::class, 'single_department'])->name("employee.attendance.current.month..department.single");

    Route::get('attendance/pdf/generator', AttendanceGenerator::class)->name("employee.attendance.pdf.generator");

    Route::prefix('export/')->name('export.excel.')->controller(ExcelEmployeeExportController::class)
        ->group(function () {
            Route::get('attendance/{department:id}', 'attendance')->name('attendance');
        });
    Route::prefix("employee/")->controller(EmployeeInfoPDF::class)->group(function () {
        Route::get('{cardInfo:id}/personal/info', 'info')->name("employee.personal.info");
        Route::get('department/{department:id}/personal/info', 'department')->name("department.employee.personal.info");
    });

});
Route::middleware(['auth'])->group(function () {
    // Card Frame Design Request Route
    Route::middleware('role:Design Card')->get('card-design/{printCardFrame:id}',CardDesign::class)->name('employee.design-card');
    // Card Frame Print Request Route
    Route::middleware('role:Print Card')->get('print-employee-card-for/{cardInfo:id}/card/{printCardFrame}', (new PrintCardController())->employee(...))->name('employee.print-card-for');

});
