<?php

namespace Sq\Guest\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Sq\Employee\Models\Gate;

class PatientGatePass extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'patient_id',
        'gate_id',
        'entered_at',
        'exit_at',
    ];

    protected $casts = [
        'entered_at' => 'datetime',
        'exit_at' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function gate(): BelongsTo
    {
        return $this->belongsTo(Gate::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
