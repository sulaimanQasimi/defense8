<?php

if (!function_exists('fingerprint')) {
    /**
     * Get the fingerprint service instance.
     *
     * @return App\Services\Fingerprint\FingerprintService
     */
    function fingerprint()
    {
        return app(App\Services\Fingerprint\FingerprintService::class);
    }
}
