<?php

use App\Http\Resources\CardInfoResource;
use Sq\Employee\Models\CardInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')
    ->prefix('api/')
    ->middleware(['api', 'auth:sanctum'])
    ->group(function () {
        Route::get('/user', fn(Request $request) => CardInfoResource::make(CardInfo::first()));
        Route::controller(\Sq\Employee\Http\Controllers\Api\CheckEmployeeInfo::class)
            ->group(function () {
                Route::get("employee/check", 'check')->name('employee.check');
            });
    });
