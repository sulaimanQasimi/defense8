<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Sq\Guest\Models\GuestGate;

class TodayExitGuestMetric extends Value
{

    public function name(){
        return trans("Today Exit Guest Metric");
    }
    public function calculate(NovaRequest $request)
    {

        return $this->count($request, GuestGate::query()->join('gates','gates.id','=','gate_id')->where('gates.level', 1)->whereNotNull('exit_at')->whereDate('exit_at', now()));
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
