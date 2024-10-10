<?php

use Acme\AppSetting\Http\Controllers\AttendaceTimerController;
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

Route::get('/requirement', function (Request $request) {

    // $app = new \App\Settings\Login();
    // $app->title = "6564";
    // $app->save();
    return [
        'title' => app(\App\Settings\Login::class)->title,
        'subtitle' => app(\App\Settings\Login::class)->subtitle
    ];
});

Route::controller(AttendaceTimerController::class)->group(function () {
    Route::get('attendance/', 'get');
    Route::get('attendance/save', 'post');

});
Route::get('/setter', function (Request $request) {
    if ($request->has(['title', 'subtitle'])) {
        $app = new \App\Settings\Login();
        $app->title = $request->input('title', '');
        $app->subtitle = $request->input('subtitle', '');
        $app->save();
    }
})->middleware(['auth', 'role:super-admin']);
