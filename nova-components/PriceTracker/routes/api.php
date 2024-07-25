<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/', function (Request $request) {
    return 54863;
})->name("price-tracker.department");

Route::get('/generate-attendance/{department}/{month}/{year}', function (Request $request,$department, $month, $year) {
    return route('employee.attendance.current.month.department.single', ['department' => $department, 'month' => $month, 'year' => $year]);

})->name("price-tracker.generate-attendance");
