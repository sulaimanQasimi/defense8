<?php
namespace App\Support;

use App\Models\Card\CardInfo;
use App\Models\Card\Driver;
use App\Models\Card\Vehical;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasDriver
{

   /**
     * Has One Driver
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(CardInfo::class, 'driver_id');
    }
}
