<?php

use App\Http\Controllers\YoutubeController;
use App\Livewire\Setting\LanguageAutomization;
use Illuminate\Support\Facades\Route;

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
Route::get('test', function () {
    $app = new \App\Settings\Login();
    $app->title = "6564";
    $app->save();
    return app(\App\Settings\Login::class)->title;
});

