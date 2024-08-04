<?php

namespace App\Nova\Metrics;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;
use Sq\Guest\Models\Guest;

class GuestCount extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        /**
         * If the user does not have a host, the method calls
         * the count method with two arguments:
         * the $request object and the Guest model's query builder.
         */
        if ($request->user()->host) {
            return $this->count($request, Guest::query()->where('host_id', $request->user()->host->id));
        }
        return $this->count($request, Guest::class);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => Nova::__('30 Days'),
            60 => Nova::__('60 Days'),
            90 => Nova::__('90 Days'),
            'ALL'=> Nova::__('All'),
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
    public function name()
    {
        return __('Guest Count');
    }
}
