<?php

namespace App\Nova\Metrics;

use App\Models\GuestGate;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;

class TodayEnterGuestMetric extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */

     public function name(){
        return trans("Today Enter Guest Metric");
    }
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, GuestGate::query()->join('gates','gates.id','=','gate_id')->where('gates.level', 1)->whereNotNull('entered_at')->whereDate('entered_at',now()));
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [];
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
