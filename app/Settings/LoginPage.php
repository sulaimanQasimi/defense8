<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class LoginPage extends Settings
{

    public static function group(): string
    {
        return 'Application';
    }
}