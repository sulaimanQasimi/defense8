<?php

namespace App\Models\Card;

use App\Support\HasCardInfo;
use App\Support\HasDriver;
use App\Support\HasVehical;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlackMirrorVehicalCard extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasCardInfo;
    protected $casts=[
        "birthday"=>"date"
    ];
}
