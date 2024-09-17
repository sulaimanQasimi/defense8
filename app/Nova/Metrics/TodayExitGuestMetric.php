<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Sq\Guest\Models\GuestGate;

class TodayExitGuestMetric extends Value
{

    public function name()
    {
        return trans("Today Exit Guest Metric");
    }
    public function calculate(NovaRequest $request)
    {

        return $this->result(
            GuestGate::query()
                ->whereHas('gate', function ($query) {
                    return $query->where('gates.level', 1);
                })
                ->whereNotNull('exit_at')
                ->whereDate('exit_at', now())

                ->whereHas('guest', function ($query) use ($request) {
                    return $query->whereHas(relation: 'host', callback: function ($query) use ($request) {
                        return $query->where('department_id', $request->input('range'));
                    });
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
