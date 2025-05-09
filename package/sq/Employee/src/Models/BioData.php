<?php

namespace Sq\Employee\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Sq\Employee\Models\Contracts\BioDataAttributes;

class BioData extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    use BioDataAttributes;

    protected $fillable = [
        'personal_info_id',
        'Manufacturer',
        'Model',
        'SerialNumber',
        'ImageWidth',
        'ImageHeight',
        'ImageDPI',
        'ImageQuality',
        'NFIQ',
        'ImageDataBase64',
        'BMPBase64',
        'ISOTemplateBase64',
        'TemplateBase64',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }

    /**
     * Get the CardInfo that owns the BioData.
     */
    public function cardInfo(): BelongsTo
    {
        return $this->belongsTo(CardInfo::class, 'personal_info_id');
    }
}