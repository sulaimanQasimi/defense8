<?php

use App\Http\Controllers\CurrentMonthEmployeeAttendance;
use App\Http\Controllers\Employee\PrintCardController;
use App\Http\Controllers\EmployeeInfoPDF;
use App\Http\Controllers\EmployeeScanCard;
use App\Http\Controllers\ExcelEmployeeExportController;
use App\Http\Controllers\Guest\QRCodeGenerateController;
use App\Http\Controllers\Oil\OilDisterbution;
use App\Livewire\CardDesign;
use App\Livewire\Setting\LanguageAutomization;
use App\Models\GuestGate;
use Illuminate\Support\Facades\Route;

// Guests Routes
Route::prefix("guest")
    ->controller(QRCodeGenerateController::class)
    ->group(function () {
        //
        Route::middleware(['auth', "guestGatePassed"])->get('passguest/{guest:id}/to', 'state')->name('guest.check');
        //
        Route::middleware(['auth', "guestGatePassed"])->get('passemployee/{cardInfo:id}/to', 'employeeState')->name('employee.check');
        //
        Route::middleware(['auth', 'can:generate,guest'])->get('/generate/{guest:id}', 'generate')->name('guest.generate');
    });
Route::middleware(['auth', "guestGatePassed", 'can:gateChecker,\App\Models\Gate'])
    ->controller(EmployeeScanCard::class)
    ->name('employee.check.')
    ->group(function () {
        // Self Website Check
        Route::get('employee', 'scan')->name('card');
        // Other Orginization
        Route::middleware(['permission:see-other-website-data'])->get('other', 'scan_other_website_employee')->name('other-website-employee');
    });
// Other Website Employees Check
Route::middleware(['auth', 'permission:see-other-website-data'])
    ->get('other-websites', (new EmployeeScanCard())->scan_other_website_employee(...))
    ->name('check.other-website-employee');
// Guests Report Only Admin
Route::middleware(['auth', 'role:super-admin'])
    // ->prefix('report/guest/')
    ->group(function () {
        Route::get('guest/pdf', \App\Http\Controllers\Report\CustomGuestsReport::class)->name('guest.report.pdf');
        Route::get('guest/excel', [\App\Http\Controllers\Report\CustomGuestsReport::class, 'excel_report'])->name('guest.report.excel');
    });
Route::middleware(['auth'])
    ->group(function () {

        Route::middleware(['role:super-admin'])->get("attend", \App\Livewire\Attendance::class)->name("employee.attendance.check");
        Route::middleware(['can:admin,department', 'permission:check own department attendance'])->get("attendance/{department:id?}", \App\Livewire\Department\SetAttendance::class)->name("department.employee.attendance.check");
        Route::middleware(['role:super-admin'])->get('employee/attendance/current/month', CurrentMonthEmployeeAttendance::class)->name("employee.attendance.current.month");
        Route::middleware(['role:super-admin'])->get('employee/attendance/current/month/employee/{cardInfo:id}', [CurrentMonthEmployeeAttendance::class, 'single_employee'])->name("employee.attendance.current.month.single");
        Route::middleware(['role:super-admin'])->get('employee/attendance/current/month/department/{department:id}', [CurrentMonthEmployeeAttendance::class, 'single_department'])->name("employee.attendance.current.month.department.single");

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
    Route::middleware('role:Print Card')->get('print/employeeCar/{employeeVehicalCard:id}/card/{printCardFrame}', (new PrintCardController())->employee_car(...))->name('employee-car.print-card-for');
});


//
Route::middleware(['auth', 'permission:change_language'])
    ->prefix('app/setting/')
    ->name('app.setting.')
    ->group(function () {
        Route::get('language/{file}', LanguageAutomization::class)->name('language');
    });
//
Route::middleware(['auth', 'permission:access_to_disterbuted_oil_page'])
    ->controller(OilDisterbution::class)->group(function () {
        Route::get('oil', 'index')->name('oil');
        Route::put('oil/{cardInfo:id}', 'store')->name('oil.store');



    });
Route::middleware(['auth', 'role:super-admin'])->group(function () {

    Route::get("oil/report/disterbuted", \App\Http\Controllers\Oil\DisterbutedOil::class);
    Route::get("oil/report/imported", \App\Http\Controllers\Oil\ImportedOil::class);

});


Route::get("test", function () {

    dd(
        GuestGate::query()->whereHas(

            'guest.host',
            function ($query) {
                return $query->where("department_id", 1);
            }
        )
            ->toSql()
    );

});
