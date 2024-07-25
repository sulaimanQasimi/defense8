<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;
use Vehical\Vehical;

class RemainPetrol extends Value
{
    public function calculate(NovaRequest $request)
    {
        // return $this->count($request, Model::class);
        return $this->result(Vehical::remain_petrol_oil())
            ->format([
                'thousandSeparated' => true,
                'mantissa' => 0,
            ])->suffix(trans("Liter", ['value' => '']));
    }
    public function ranges()
    {
        return [
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }
}
