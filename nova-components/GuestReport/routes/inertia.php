<?php

use Illuminate\Support\Facades\Route;
use Laravel\Nova\Http\Requests\NovaRequest;

/*
|--------------------------------------------------------------------------
| Tool Routes
|--------------------------------------------------------------------------
|
| Here is where you may register Inertia routes for your tool. These are
| loaded by the ServiceProvider of the tool. The routes are protected
| by your tool's "Authorize" middleware by default. Now - go build!
|
*/

Route::get('/', function (NovaRequest $request) {

    $url=config('guest-report.custom');

    $years = [];
    for ($i = 1388; $i <= verta()->year; $i++) {
        $years[] = $i;
    }

    $days = [];

    for ($i = 1; $i <= 31; $i++) {
        $days[] = $i;
    }
    return inertia('GuestReport',compact('years','days','url'));
});
