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

// Route::get('/', function (Request $request) {
//     //
// });

Route::get('requirement', function () {
    return [
        "fields" => [
            ['key' => "registare_no", 'label' => __('Register No'),],
            ['key' => "full_name", 'label' => __('Name'),],
            ['key' => "father_name", 'label' => __('Father Name'),],
            ['key' => "department", 'label' => __('Department'),],
            ['key' => "oil_type", 'label' => __('Oil Type'),],
            ['key' => "monthly_rate", 'label' => __('Monthly Rate'),],
            ['key' => "oil_amount", 'label' => __('Oil Amount'),],
            ['key' => "date", 'label' => __('Date'),],
        ],
        "now" => verta()->format("Y/m/d"),
        "path" => config("Oil-report.path"),
        "importOil" => config("Oil-report.import"),
        "disterbute" => config("Oil-report.disterbute"),

    ];
});
