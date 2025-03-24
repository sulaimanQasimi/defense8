<?php
use Illuminate\Support\Facades\Route;
use Sq\Guest\Http\Controllers\QRCodeGenerateController;
use Sq\Guest\Http\Controllers\Report\CustomGuestsReport;


// Guests Routes
Route::prefix("guest")
    ->controller(QRCodeGenerateController::class)
    ->group(function () {
        //
        Route::middleware(["guestGatePassed"])->get('passguest/{guest:id}/to', 'state')->name('guest.check');
        //
        //
        Route::middleware(['can:generate,guest'])->get('/generate/{guest:id}', 'generate')->name('guest.generate');
    });

    // Guests Report Only Admin
Route::middleware(['role:super-admin'])
    // ->prefix('report/guest/')
    ->group(function () {
    Route::get('guest/report', CustomGuestsReport::class)->name('guest.report');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('guest/{guest:id}/generate', [QRCodeGenerateController::class, 'generate'])->name('guest.generate');
    Route::get('patient/{patient:id}/generate', [QRCodeGenerateController::class, 'generatePatient'])->name('patient.generate');
});
