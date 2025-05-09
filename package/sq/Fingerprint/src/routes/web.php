<?php

use Illuminate\Support\Facades\Route;
use Sq\Fingerprint\Http\Controllers\FingerprintController;
use Sq\Fingerprint\Http\Controllers\BioDataController;
use Sq\Fingerprint\Http\Controllers\CardInfoBiometricController;

/*
|--------------------------------------------------------------------------
| Fingerprint Routes
|--------------------------------------------------------------------------
|
| Here is where you can register fingerprint-related routes for your package.
|
*/

Route::middleware(['web', 'auth'])->group(function () {
    // Fingerprint identification page
    Route::get('/identification', [FingerprintController::class, 'index'])->name('fingerprint.identification');

    // Fingerprint matching API endpoint
    Route::post('/match', [FingerprintController::class, 'match'])->name('fingerprint.match');

    // Template management
    Route::prefix('template')->name('fingerprint.template.')->group(function () {
        // Save fingerprint template
        Route::post('store', [FingerprintController::class, 'store'])->name('store');

        // Verify fingerprint against stored template
        Route::post('verify', [FingerprintController::class, 'verify'])->name('verify');

        // Delete fingerprint template
        Route::delete('delete', [FingerprintController::class, 'delete'])->name('delete');
    });

    // Biometric data routes
    Route::prefix('biodata')->name('fingerprint.biodata.')->group(function () {
        Route::get('{record_id}', [BioDataController::class, 'show'])->name('show');
        Route::get('{record_id}/page', [BioDataController::class, 'showPage'])->name('page');
        Route::post('{record_id}', [BioDataController::class, 'store'])->name('store');
        Route::delete('{record_id}', [BioDataController::class, 'destroy'])->name('destroy');
        Route::post('{record_id}/verify', [BioDataController::class, 'verify'])->name('verify');
    });

    // CardInfo Biometric routes
    Route::prefix('cardinfo')->name('fingerprint.cardinfo.')->group(function () {
        Route::get('/', [CardInfoBiometricController::class, 'index'])->name('index');
        Route::post('match', [CardInfoBiometricController::class, 'matchFingerprint'])->name('match');
        Route::get('all', [CardInfoBiometricController::class, 'getAllWithBiometricData'])->name('all');
        // New verification routes
        Route::get('verify/{cardInfoId?}', [CardInfoBiometricController::class, 'showVerificationPage'])->name('verify.page');
        Route::post('verify', [CardInfoBiometricController::class, 'verifyFingerprint'])->name('verify');
        // Save biometric data route
        Route::post('{cardInfoId}/biodata', [CardInfoBiometricController::class, 'saveBiometricData'])->name('biodata.save');

        Route::get('{id}', [CardInfoBiometricController::class, 'getCardInfo'])->name('show');

    });
});
