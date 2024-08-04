<?php

use App\Livewire\Setting\LanguageAutomization;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'permission:change_language'])
    ->prefix('app/setting/')
    ->name('app.setting.')
    ->group(function () {
        Route::get('language/{file}', LanguageAutomization::class)->name('language');
    });
//
