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
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Facades\Route;
use Sq\Query\OilStatistics;
use Vehical\OilType;

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

    // Guests Report Only Admin
Route::middleware(['auth', 'role:super-admin'])
    // ->prefix('report/guest/')
    ->group(function () {
    Route::get('guest/report', \App\Http\Controllers\Report\CustomGuestsReport::class)->name('guest.report');
});
Route::middleware(['auth', 'permission:change_language'])
    ->prefix('app/setting/')
    ->name('app.setting.')
    ->group(function () {
        Route::get('language/{file}', LanguageAutomization::class)->name('language');
    });
//
