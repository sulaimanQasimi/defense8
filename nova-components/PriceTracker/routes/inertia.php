<?php

use Acme\PriceTracker\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\DB;
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

Route::get('/',[LanguageController::class,'index']);
Route::get('/generage',[LanguageController::class,'generate_report']);
Route::get('/as', function (NovaRequest $request) {

    return DB::table('users')->take(5)->get();

});
