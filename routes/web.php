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
use App\Livewire\Setting\LanguageAutomization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\BackupTool\Jobs\CreateBackupJob;


// Guests Routes
Route::prefix("guest")
    ->controller(QRCodeGenerateController::class)
    ->group(function () {
        Route::middleware(['auth', "guestGatePassed"])->get('passguest/{guest:id}/to', 'state')->name('guest.check');
        Route::middleware(['auth', "guestGatePassed"])->get('passemployee/{cardInfo:id}/to', 'employeeState')->name('employee.check');
        Route::middleware('auth')->get('/generate/{guest:id}', 'generate')->name('guest.generate');
    });


Route::middleware(['auth', "guestGatePassed"])
    ->controller(EmployeeScanCard::class)->group(function () {
        Route::middleware(['can:gateChecker,\App\Models\Gate'])->get('employee', 'scan')->name('employee.check.card');
        Route::get('other', 'scan_other_website_employee')
            ->name('employee.check.other-website-employee');
    });

// Other Website Employees Check
Route::middleware(['auth', 'permission:see-other-website-data',])
    ->get('other-websites', (new EmployeeScanCard())->scan_other_website_employee(...))
    ->name('check.other-website-employee');


// Guests Report Only Admin
Route::middleware(['auth', 'role:super-admin'])
    ->prefix('report/guest/')
    ->name('guest.report.')
    ->group(function () {
        Route::get('daily', DailyGuestsReport::class)->name('daily');
        Route::get('monthy', \App\Http\Controllers\Report\MonthlyGuestsReport::class)->name('monthly');
        Route::get('weekly', \App\Http\Controllers\Report\WeeklyGuestsReport::class)->name('weekly');
        Route::get('yearly', \App\Http\Controllers\Report\YearlyGuestsReport::class)->name('yearly');
    });

Route::middleware(['auth'])
    ->group(function () {
        Route::middleware(['role:super-admin'])->get("attend", \App\Livewire\Attendance::class)->name("employee.attendance.check");
        Route::middleware(['can:admin,department'])->get("attendance/{department:id?}", \App\Livewire\Department\SetAttendance::class)->name("department.employee.attendance.check");
        Route::middleware(['role:super-admin'])->get('employee/attendance/current/month', CurrentMonthEmployeeAttendance::class)->name("employee.attendance.current.month");
        Route::middleware(['role:super-admin'])->get('employee/attendance/current/month/employee/{cardInfo:id}', [CurrentMonthEmployeeAttendance::class, 'single_employee'])->name("employee.attendance.current.month.single");
        Route::middleware(['role:super-admin'])->get('employee/attendance/current/month/department/{department:id}', [CurrentMonthEmployeeAttendance::class, 'single_department'])->name("employee.attendance.current.month..department.single");
        Route::middleware(['role:super-admin'])->get('attendance/pdf/generator', AttendanceGenerator::class)

            ->name("employee.attendance.pdf.generator");

        Route::prefix('export/')->name('export.excel.')
            ->controller(ExcelEmployeeExportController::class)
            ->group(function () {
                Route::get('attendance/{department:id}', 'attendance')->name('attendance');
            });

        Route::prefix("employee/")
            ->controller(EmployeeInfoPDF::class)
            ->group(function () {

                Route::get('{cardInfo:id}/personal/info', 'info')
                    ->name("employee.personal.info");
                Route::get('department/{department:id}/personal/info', 'department')
                    ->name("department.employee.personal.info");
            });
    });


// Group for Desining and Printing Cards
Route::middleware(['auth'])->group(function () {

    // Card Frame Design Request Route
    Route::middleware('role:Design Card')->get('card-design/{printCardFrame:id}', CardDesign::class)->name('employee.design-card');



    // Card Frame Print Request Route

    // Employee Card
    Route::middleware('role:Print Card')->get('print-employee-card-for/{cardInfo:id}/card/{printCardFrame}', (new PrintCardController())->employee(...))->name('employee.print-card-for');

    // Gun Card
    Route::middleware('role:Print Card')->get('print/gun/{cardInfo:id}/card/{printCardFrame}', (new PrintCardController())->gun(...))->name('gun.print-card-for');

    // Employee Car Card
    Route::middleware('role:Print Card')->get('print/employeeCar/{cardInfo:id}/card/{printCardFrame}', (new PrintCardController())->employee_car(...))->name('employee-car.print-card-for');

    // Armor Car Card
    Route::middleware('role:Print Card')->get('print/ArmorCar/{cardInfo:id}/card/{printCardFrame}', (new PrintCardController())->armor_car(...))->name('armor-car.print-card-for');

    // Black Mirror Car Card
    Route::middleware('role:Print Card')->get('print/blackMirrorCar/{cardInfo:id}/card/{printCardFrame}', (new PrintCardController())->black_mirror_car(...))->name('black-mirror-car.print-card-for');


});


//
Route::middleware(['auth', 'role:super-admin'])
    ->prefix('app/setting/')
    ->name('app.setting.')
    ->group(function () {
        Route::get('language', LanguageAutomization::class)->name('language');
    });


Route::get('test', function () {

    $option = '';
    dispatch(new CreateBackupJob);
});
