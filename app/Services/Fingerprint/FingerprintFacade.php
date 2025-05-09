<?php

namespace App\Services\Fingerprint;

use Illuminate\Support\Facades\Facade;

class FingerprintFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fingerprint';
    }
}
