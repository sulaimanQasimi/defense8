<?php

namespace Sq\Oil\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oil extends Model
{
    use HasFactory;
    protected $casts = [
        'filled_date' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(
            function ($oil) {
                $fetch = Oil::query()->whereYear("filled_date", now()->year)->whereNot('id', $oil->id)->count();
                $oil->code = verta()->format("Y/m/d-" . $fetch + 1);
                $oil->save();
            }
        );
    }

}
