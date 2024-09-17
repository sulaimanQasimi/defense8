<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;
use Sq\Employee\Models\GunCard;

class GunTrends extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->result(GunCard::query()
            ->whereHas('card_info', function ($query) use ($request) {
                return $query->where('department_id', $request->input('range'));
            })->count())
            ->format([
                'thousandSeparated' => true,
                'mantissa' => 0,
            ]);
        ;
    }
    public function uriKey()
    {
        return 'gun-trends';
    }

    public function name()
    {
        return __('Registered Gun');

    }

    public function ranges()
    {
        return auth()->user()->departments()->orderBy('fa_name')->pluck('fa_name', 'departments.id')->toArray();
    }
}
