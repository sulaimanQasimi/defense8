<?php

use Alkoumi\LaravelHijriDate\Hijri;
use App\Http\Controllers\YoutubeController;
use App\Livewire\Setting\LanguageAutomization;
use Illuminate\Support\Facades\Route;
use Sq\Employee\Models\Department;
use Sq\Query\Policy\UserDepartment;

Route::middleware(['auth', 'permission:change_language'])
    ->prefix('app/setting/')
    ->name('app.setting.')
    ->group(function () {
        Route::get('language/{file}', LanguageAutomization::class)->name('language');
    });
//
Route::middleware(['auth'])
    ->controller(controller: YoutubeController::class)
    ->group(callback: function () {
        Route::get(uri: 'youtube', action: 'list')->name('youtube.list');
        Route::get(uri: 'youtube/preview/{video:id}', action: 'preview')->name('youtube.preview');
    });
Route::get('test', function () {
    dd(UserDepartment::getUserGuestGate());
});
