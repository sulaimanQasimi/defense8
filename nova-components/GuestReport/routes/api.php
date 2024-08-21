<?php

use Acme\GuestReport\Http\Controller\ApiController;
use Sq\Employee\Models\Department;
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

Route::get('/departments', [ApiController::class, 'departments']);
Route::get('/guests', [ApiController::class, 'guests']);
Route::get('requirement', function () {
    return [
        "fields" => [
            ['key' => "name", 'label' => __('Name'),],
            ['key' => "last_name", 'label' => __('Last Name'),],
            ['key' => "career", 'label' => __('Job'),],
            ['key' => "address", 'label' => __('Address'),],
            ['key' => "head_name", 'label' => __('Host'),],
            ['key' => "department", 'label' => __('Department'),],
            ['key' => "job", 'label' => __('Job'),],
            ['key' => "hostAddress", 'label' => __('Address'),],
            ['key' => "phone", 'label' => __('Phone'),],
            ['key' => "registered_at", 'label' => __('Enter'),],
        ],
    ];
});
