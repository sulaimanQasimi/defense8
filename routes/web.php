<?php

use App\Http\Controllers\YoutubeController;
use App\Livewire\Setting\LanguageAutomization;
use Illuminate\Support\Facades\Route;
use Sq\Employee\Models\Department;
use Sq\Employee\Models\Gate;
use Sq\Guest\Models\Host;
use Sq\Query\OilStatistics;
use Sq\Query\Policy\UserDepartment;
use Sq\Query\Resource\NameSugestion;

Route::middleware(['auth', 'permission:change_language'])
    ->prefix('app/setting/')
    ->name('app.setting.')
    ->group(function () {
        Route::get('language/{file}', LanguageAutomization::class)->name('language');
    });
//
Route::middleware(['auth'])
    ->controller(YoutubeController::class)
    ->group(function () {
        Route::get('youtube', 'list')->name('youtube.list');
        Route::get('youtube/preview/{video:id}', 'preview')->name('youtube.preview');
    });
Route::middleware(['auth'])->get('test', function () {




    $statistic = (new OilStatistics())->make();




    $result = match ('current_month_import') {
        'current_month_import' => $statistic['current_month']['import'][\Vehical\OilType::Petrole],
        'current_month_export' => $statistic['current_month']['export'][\Vehical\OilType::Petrole],
        'current_month_remain' => $statistic['current_month']['remain'][\Vehical\OilType::Petrole],
        'past_month_import' => $statistic['past_month']['import'][\Vehical\OilType::Petrole],
        'past_month_export' => $statistic['past_month']['export'][\Vehical\OilType::Petrole],
        'past_month_remain' => $statistic['past_month']['remain'][\Vehical\OilType::Petrole],
    };
    dd($result);
});

