<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AttendanceTimer extends Settings
{
    public string $start;
    public string $end;

    public static function group(): string
    {
        return 'attendance';
    }
}
