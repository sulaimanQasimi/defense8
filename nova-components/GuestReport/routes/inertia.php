<?php

use Acme\GuestReport\Http\Controller\ApiController;
use App\Models\Guest;
use App\Models\GuestGate;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
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
    return inertia('GuestReport', [
        "request"=>request()->all(),
        'guests' => (new ApiController)->guest(),
        'now'=>verta()->format("Y/m/d")

      ]);
});

