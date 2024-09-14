<?php

use App\Http\Controllers\YoutubeController;
use App\Livewire\Setting\LanguageAutomization;
use Illuminate\Support\Facades\Route;
use Sq\Employee\Models\Department;
use Sq\Employee\Models\Gate;
use Sq\Guest\Models\Host;
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
// Host::create([
//     'department_id'=>1,

// ]);
// $host=Gate::find(1);
// $host->update([  'department_id'=>2,]);
dd(
    // \Sq\Guest\Models\Host::query()
    // ->whereIn('department_id', UserDepartment::getUserDepartment())
    // ->pluck('head_name', 'id')
    // ->toArray()
    NameSugestion::make()
);
});

