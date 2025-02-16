<?php

namespace Sq\Employee\Models;


use App\Support\HasCardInfo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class MainCard extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasCardInfo;
    use LogsActivity;
    protected $fillable = [
        "card_perform",
        "card_expired_date",
        'printed',
        'remark',
        'printed_at'
    ];

    protected $casts = [
        "card_second_date" => 'date',
        "card_perform" => 'date',
        "card_expired_date" => 'date',
        'printed_at' => 'date',
        'printed' => 'boolean'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
