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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'oil_type',
        'oil_amount',
        'oil_quality',
        'filled_date',
        'pump_station_id'
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

    /**
     * Get the oil quality relationship.
     */
    public function oil_quality(): BelongsTo
    {
        return $this->belongsTo(OilQuality::class);
    }

    /**
     * Get the pump station that this oil belongs to.
     */
    public function pumpStation(): BelongsTo
    {
        return $this->belongsTo(PumpStation::class);
    }
}
