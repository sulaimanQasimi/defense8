<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;
use Sq\Guest\Models\Guest;

class HostGuestValue extends Value
{

    public function calculate(NovaRequest $request)
    {
        return $this->result(
            Guest::query()
            ->whereHas('host', function ($query) use ($request) {
                return $query->where('department_id', $request->input('range'));
            })->count())

            ->format([
                    'thousandSeparated' => true,
                    'mantissa' => 0,
                ]);
    }
    public function ranges()
    {
        return auth()->user()->departments()->orderBy('fa_name')->pluck('fa_name', 'departments.id')->toArray();
    }
}
