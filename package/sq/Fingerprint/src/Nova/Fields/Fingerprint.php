<?php

namespace Sq\Fingerprint\Nova\Fields;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Fingerprint extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'fingerprint-field';

    /**
     * The image height.
     *
     * @var int
     */
    public $height = 200;

    /**
     * The image width.
     *
     * @var int
     */
    public $width = 200;

    /**
     * The image quality.
     *
     * @var int
     */
    public $quality = 100;

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  mixed|null  $resolveCallback
     * @return void
     */
    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->onlyOnDetail();
    }

    /**
     * Set the height of the fingerprint display.
     *
     * @param  int  $height
     * @return $this
     */
    public function height($height)
    {
        $this->height = $height;

        return $this->withMeta(['height' => $height]);
    }

    /**
     * Set the width of the fingerprint display.
     *
     * @param  int  $width
     * @return $this
     */
    public function width($width)
    {
        $this->width = $width;

        return $this->withMeta(['width' => $width]);
    }

    /**
     * Set the image quality of the fingerprint.
     *
     * @param  int  $quality
     * @return $this
     */
    public function quality($quality)
    {
        $this->quality = $quality;

        return $this->withMeta(['quality' => $quality]);
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'height' => $this->height,
            'width' => $this->width,
            'quality' => $this->quality,
            'imageUrl' => $this->getImageUrl(),
            'recordId' => $this->getRecordId(),
            'captureUrl' => route('fingerprint.biodata.page', ['record_id' => $this->getRecordId()]),
        ]);
    }

    /**
     * Get the record ID for the current resource.
     *
     * @return mixed
     */
    protected function getRecordId()
    {
        $resource = $this->resource;
        return $resource ? $resource->getKey() : null;
    }

    /**
     * Get the image URL for the fingerprint.
     *
     * @return string|null
     */
    protected function getImageUrl()
    {
        $recordId = $this->getRecordId();
        
        if (!$recordId) {
            return null;
        }
        
        $bioData = \Sq\Fingerprint\Models\BiometricData::where('record_id', $recordId)->first();
        
        if (!$bioData || !$bioData->BMPBase64) {
            return asset('vendor/sq-fingerprint/img/fingerprint-placeholder.png');
        }
        
        return 'data:image/bmp;base64,' . $bioData->BMPBase64;
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        // We don't need to fill anything from the request for this field
        // Fingerprint data is stored via the API endpoints
    }
} 