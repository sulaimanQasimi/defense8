<?php

namespace App\Nova\Metrics;

use App\Models\Attendance;
use App\Models\CardInfoGate;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;

class TodayExitEmployeeMetric extends Value
{
    public function name()
    {
        return trans("Today Exit Employee Metric");
    }
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, Attendance::query()->where('state', 'P')->whereDate('date', now())->whereNotNull('exit'));
    }

    public function ranges()
    {
        return [

        ];
    }
    public function cacheFor(): void
    {
        // return now()->addMinutes(5);
    }
}
