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

Route::get('/generate-attendance/{department}/{month}/{year}', function (Request $request, $department, $month, $year) {
    return route('employee.attendance.current.month.department.single', ['department' => $department, 'month' => $month, 'year' => $year]);

})->name("price-tracker.generate-attendance");
Route::get('/requirement', function () {

    $years = [];
    
    for ($i = 1388; $i <= verta()->year; $i++) {
        $years[] = [
            "display" => $i,
            "value" => $i
        ];
    }

    return [
        "months" => [
            ["display" => __('Hamal'), "value" => 1],
            ["display" => __('Thour'), "value" => 2],
            ["display" => __('Jawza'), "value" => 3],
            ["display" => __('Sarathan'), "value" => 4],
            ["display" => __('Asad'), "value" => 5],
            ["display" => __('Sunbulah'), "value" => 6],
            ["display" => __('Mizan'), "value" => 7],
            ["display" => __('Aqrab'), "value" => 8],
            ["display" => __('Qous'), "value" => 9],
            ["display" => __('Jadi'), "value" => 10],
            ["display" => __('Dalwa'), "value" => 11],
            ["display" => __('Hod'), "value" => 12],
        ],
        "years" => $years,
        "currentYear" => verta()->year
    ];
});
