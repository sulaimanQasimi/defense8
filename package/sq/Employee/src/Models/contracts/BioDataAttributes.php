<?php

namespace Sq\Employee\Models\Contracts;

trait BioDataAttributes
{
    /**
     * Get the fingerprint template as base64.
     */
    public function getTemplateAttribute()
    {
        return $this->TemplateBase64;
    }

    /**
     * Get the fingerprint image as base64.
     */
    public function getImageAttribute()
    {
        return $this->BMPBase64;
    }

    /**
     * Get the fingerprint quality.
     */
    public function getQualityAttribute()
    {
        return $this->ImageQuality;
    }
}
