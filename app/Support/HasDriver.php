<?php
namespace App\Support;


use Sq\Employee\Models\CardInfo;
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
