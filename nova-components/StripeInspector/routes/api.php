<?php

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Sq\Employee\Models\CardInfo;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. You're free to add
| as many additional routes to this file as your tool may require.
|
*/

Route::get('/', function (Request $request) {
    return [
        'year' => verta()->year,
        'month' => verta()->month
    ];
});
Route::get('/attendance/{cardInfo:id}', function (Request $request, CardInfo $cardInfo) {


    $start = Verta::parse(Verta::setDateJalali($request->input('year',verta()->year), $request->input('month',verta()->month), 1)->startMonth())->toCarbon();
    $end = Verta::parse(Verta::setDateJalali($request->input('year',verta()->year), $request->input('month',verta()->month), 1)->endMonth())->toCarbon();
    $day = array_fill(1, 31, '');

    foreach ($cardInfo->attendance()->orderBy('date', 'ASC')->whereBetween("date", [$start, $end])->get() as $attendance) {
        $day[intval($attendance->shamsi_day)] = $attendance->label;
    }
    $days = collect($cardInfo->attendance);

    return [
        'attendances'=>$day,
        'start'=>Verta::setDateJalali($request->input('year',verta()->year), $request->input('month',verta()->month), 1)->startMonth(),
        'end'=>Verta::setDateJalali($request->input('year',verta()->year), $request->input('month',verta()->month), 1)->endMonth(),
        "present"=>$days->where('state', 'P')->count(),
        "absent"=>$days->where('state', 'U')->count(),
    ];
});
