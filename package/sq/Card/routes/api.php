<?php

Route::prefix('api/')
    ->middleware('web')
    ->get('design-cards', function () {
        return (new \Sq\Card\Support\ShareCardApi)->share();
    });
