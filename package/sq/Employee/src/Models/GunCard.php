<?php

namespace Sq\Employee\Models;

use App\Support\HasCardInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GunCard extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasCardInfo;

    protected $fillable = [
        'register_date' => "date",
        'expire_date' => "date",
        "filled_form_date"=> "date",
    ];   
   protected $casts = [
        'register_date' => "date",
        'expire_date' => "date",
        "filled_form_date"=> "date",
    ];
}
