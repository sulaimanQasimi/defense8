<?php

namespace App\Support;

use App\Models\Card\Vehical;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasVehical
{

    /**
     * Has One Vehical
     */
    public function vehical(): MorphOne
    {
        return $this->morphOne(Vehical::class, 'vehicalable');
    }
}
