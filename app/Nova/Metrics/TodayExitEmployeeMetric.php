<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;
use Sq\Employee\Models\Attendance;

class TodayExitEmployeeMetric extends Value
{
    public function name()
    {
        return trans("Today Exit Employee Metric");
    }
    public function calculate(NovaRequest $request)
    {
        return $this->result(
            Attendance::query()
                ->where('state', 'P')
                ->whereDate('date', now())
                ->whereNotNull('exit')
                ->whereHas('card_info', function ($query) use ($request) {
                    return $query->where('department_id', $request->input('range'));
                })->count()
        )->format([
                    'thousandSeparated' => true,
                    'mantissa' => 0,
                ]);
        ;
    }
    public function ranges()
    {
        return auth()->user()->departments()->orderBy('fa_name')->pluck('fa_name', 'departments.id')->toArray();
    }

    public function cacheFor(): void
    {
        // return now()->addMinutes(5);
    }
}
