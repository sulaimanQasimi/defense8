<?php

use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Sq\Employee\Models\CardInfo;

Route::get('/attendance/{cardInfo:id}', function (Request $request, CardInfo $cardInfo) {


    $start = Verta::parse(Verta::setDateJalali($request->input('year', verta()->year), $request->input('month', verta()->month), 1)->startMonth())->toCarbon();
    $end = Verta::parse(Verta::setDateJalali($request->input('year', verta()->year), $request->input('month', verta()->month), 1)->endMonth())->toCarbon();
    $days = collect($cardInfo->attendance()->orderBy('date', 'ASC')->whereBetween("date", [$start, $end])->get());

    return [
        "present" => $days->where('state', 'P')->count(),
        "absent" => $days->where('state', 'U')->count(),

    ];
});

