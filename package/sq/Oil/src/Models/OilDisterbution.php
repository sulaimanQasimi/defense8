<?php

namespace Sq\Oil\Models;

use App\Support\HasCardInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OilDisterbution extends Model
{
    use HasFactory;
    use HasCardInfo;
    protected $guarded=[];
    protected $casts =[
        "filled_date"=> "date",
    ];

    /**
     * Get the pump station that this oil distribution belongs to.
     */
    public function pumpStation(): BelongsTo
    {
        return $this->belongsTo(PumpStation::class);
    }
}
