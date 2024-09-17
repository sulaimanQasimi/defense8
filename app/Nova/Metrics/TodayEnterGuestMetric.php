<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;
use Sq\Guest\Models\GuestGate;

class TodayEnterGuestMetric extends Value
{
    public function name()
    {
        return trans("Today Enter Guest Metric");
    }
    public function calculate(NovaRequest $request)
    {
        return $this->result(
            GuestGate::query()
                ->whereHas('gate', function ($query) {
                    return $query->where('gates.level', 1);
                })
                ->whereNotNull(columns: 'entered_at')
                ->whereDate(column: 'entered_at', operator: now())
                ->whereHas('guest', function ($query) use ($request) {
                    return $query->whereHas(relation: 'host', callback: function ($query) use ($request) {
                        return $query->where('department_id', $request->input('range'));
                    });
                })->count()
        )->format([
            'thousandSeparated' => true,
            'mantissa' => 0,
        ]);
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
