<?php
use Illuminate\Support\Facades\Route;
use Sq\Oil\Http\Controllers\Oil\OilDisterbution;

Route::middleware(['auth', 'permission:access_to_disterbuted_oil_page'])
    ->controller(OilDisterbution::class)
    ->group(function () {
        Route::get('oil', 'index')->name('oil');
        Route::put('oil/{cardInfo:id}', 'store')->name('oil.store');
    });

Route::middleware(['auth', 'role:super-admin'])
    ->group(function () {
        Route::get("oil/report/disterbuted", \Sq\Oil\Http\Controllers\Oil\DisterbutedOil::class);
        Route::get("oil/report/imported", \Sq\Oil\Http\Controllers\Oil\ImportedOil::class);
    });
