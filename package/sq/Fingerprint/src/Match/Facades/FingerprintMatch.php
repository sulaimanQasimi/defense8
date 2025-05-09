<?php

namespace Sq\Fingerprint\Match\Facades;

use Illuminate\Support\Facades\Facade;

class FingerprintMatch extends Facade 
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fingerprint.match';
    }
} 