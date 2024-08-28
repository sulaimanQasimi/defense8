<?php

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Sq\Employee\Models\CardInfo;

/*
|--------------------------------------------------------------------------
| Card API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your card. These routes
| are loaded by the ServiceProvider of your card. You're free to add
| as many additional routes to this file as your card may require.
|
*/

// Route::get('/endpoint', function (Request $request) {
//     //
// });

Route::get('/attendance/{cardInfo:id}', function (Request $request, CardInfo $cardInfo) {


    $start = Verta::parse(Verta::setDateJalali($request->input('year', verta()->year), $request->input('month', verta()->month), 1)->startMonth())->toCarbon();
    $end = Verta::parse(Verta::setDateJalali($request->input('year', verta()->year), $request->input('month', verta()->month), 1)->endMonth())->toCarbon();
    $days = collect($cardInfo->attendance()->orderBy('date', 'ASC')->whereBetween("date", [$start, $end])->get());

    return [
        "present" => $days->where('state', 'P')->count(),
        "absent" => $days->where('state', 'U')->count(),
        
    ];
});

