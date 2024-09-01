<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class Login extends Settings
{

    public  $title;

    public  $subtitle;



    public static function group(): string
    {
        return 'login';
    }
}
