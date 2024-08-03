<?php

namespace Sq\Employee\Models;

use App\Support\HasCardInfo;
use App\Support\HasDriver;
use App\Support\HasVehical;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeVehicalCard extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasCardInfo;
    use HasDriver;
    protected $casts = [
        'register_date' => "date",
        'expire_date' => "date",
    ];
    protected $fillable = ['remark'];


}
