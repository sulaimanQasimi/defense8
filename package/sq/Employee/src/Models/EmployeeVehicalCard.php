<?php

namespace Sq\Employee\Models;

use App\Support\HasCardInfo;
use App\Support\HasDriver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class EmployeeVehicalCard extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasCardInfo;
    use HasDriver;

    use LogsActivity;
    protected $fillable = ['remark','register_date','expire_date','printed'];
    protected $casts = [
        'register_date' => "date",
        'expire_date' => "date",
        'printed'=>'boolean',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }



}
