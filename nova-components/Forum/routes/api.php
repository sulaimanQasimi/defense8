<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/is_admin', function (Request $request) {
    return auth()->user()->hasRole('super-admin');
});
