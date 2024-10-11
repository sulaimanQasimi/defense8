<?php

use App\Http\Controllers\YoutubeController;
use App\Livewire\Setting\LanguageAutomization;
use App\Settings\AttendanceTimer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Facades\Route;
use Sq\Employee\Jobs\ApsentAndExitedEmployeeAttendance;
use Sq\Employee\Livewire\Attendance;
use Sq\Employee\Models\CardInfo;
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
    // Pipeline::
    // dd(Carbon::make(mb_split(' ', (new AttendanceTimer)->start)[0]));
    // dd(
    //     CardInfo::query()->with(['today_attendance'])->where('id','1')->get()
    // );
    // dispatch();
    ApsentAndExitedEmployeeAttendance::dispatch();
    
    ;
});

