<?php

use Acme\GuestReport\Http\Controller\ApiController;
use App\Models\Department;
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

Route::get('/departments', [ApiController::class,'departments']);
Route::get('/guests', [ApiController::class,'guests']);
