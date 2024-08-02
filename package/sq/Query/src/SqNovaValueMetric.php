<?php

namespace Sq\Query;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;

class SqNovaValueMetric extends Value
{
    public function __construct(private string $label, private $value)
    {

    }

    public function calculate(NovaRequest $request)
    {
        return $this->result($this->value)
            ->format([
                'thousandSeparated' => true,
                'mantissa' => 0,
            ])->suffix(trans("Liter", ['value' => '']));
    }

    public function ranges()
    {
    }
    public function cacheFor()
    {
        return now()->addMinutes(5);
    }
    public function name(): string
    {
        return $this->label;
    }
}
