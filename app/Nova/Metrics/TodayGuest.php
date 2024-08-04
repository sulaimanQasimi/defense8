<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;
use Sq\Guest\Models\Guest;

class TodayGuest extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        if ($request->user()->host) {
            return $this->count($request, Guest::query()->where('host_id', $request->user()->host->id)->whereDate('registered_at', today()));
        }
        return $this->count($request, Guest::query()->whereDate('registered_at', today()));
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
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
    public function cacheFor(): void
    {
        // return now()->addMinutes(5);
    }
    public function name(){
        return __('Today Guest');
    }
}
