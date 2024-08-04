<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;
use Sq\Employee\Models\Attendance;

class PresentEmployeeMetric extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */

    public function name()
    {
        return trans("Present Employee Metric");
    }
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Attendance::query()->where('state', 'P')->whereDate('date', now()));
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
}
