<?php

namespace Sq\Fingerprint\Facades;

use Illuminate\Support\Facades\Facade;
use Sq\Fingerprint\Storage\FingerprintFileStorage;

class FingerprintStorage extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fingerprint.storage';
    }
}
