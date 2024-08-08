<?php

namespace Sq\Oil\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function oil_quality(): BelongsTo
    {
        return $this->belongsTo(OilQuality::class);
    }
}
