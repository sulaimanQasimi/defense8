<?php

use App\Http\Controllers\Api\CheckEmployeeInfo;
use App\Http\Resources\CardInfoResource;
use App\Models\Card\CardInfo;
use App\Models\PrintCardFrame;
use Card\ShareCardApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/user', fn(Request $request) => CardInfoResource::make(CardInfo::first()));
        Route::controller(CheckEmployeeInfo::class)
            ->group(function () {
                Route::get("employee/check", 'check')->name('employee.check');
            });
    });

Route::get('design-cards', function () {
    return (new ShareCardApi)->share();
});
