<?php
namespace App\Support;

use App\Models\Card\Driver;
use App\Models\Card\Vehical;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasDriver
{

   /**
     * Has One Driver
     */
    public function driver(): MorphOne
    {
        return $this->morphOne(Driver::class, 'driverable');
    }
}
