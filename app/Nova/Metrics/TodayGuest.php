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
        return $this->result(
            Guest::query()
                ->whereDate('registered_at', today())
                ->whereHas('host', function ($query) use ($request) {
                    return $query->where('department_id', $request->input('range'));
                })->count()
        )->format([
                    'thousandSeparated' => true,
                    'mantissa' => 0,
                ]);
        ;
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */

    public function ranges()
    {
        return auth()->user()->departments()->orderBy('fa_name')->pluck('fa_name', 'departments.id')->toArray();
    }
    public function name()
    {
        return __('Today Guest');
    }
}
