<?php

namespace Sq\Fingerprint\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool store(array $data, string $identifier)
 * @method static bool delete(string $identifier)
 * @method static array|bool match(array $data, array $identifiers = [], bool $debug = false)
 * 
 * @see \Sq\Fingerprint\Services\FingerprintService
 */
class Fingerprint extends Facade
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