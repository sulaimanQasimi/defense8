<?php

namespace Sq\Employee\Models;

use App\Support\HasCardInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GunCard extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasCardInfo;
    use LogsActivity;

    protected $fillable = [
        'register_date',
        'expire_date',
        'filled_form_date',
        'printed'
    ];
    protected $casts = [
        'register_date' => 'date',
        'expire_date' => 'date',
        'filled_form_date' => 'date',
        'printed' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
