<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;
use Sq\Employee\Models\CardInfo;

class EmpolyeeTrends extends Value
{
    public function calculate(NovaRequest $request)
    {
        return $this->result(CardInfo::query()
            ->where('department_id', $request->input('range'))->count())
            ->format([
                'thousandSeparated' => true,
                'mantissa' => 0,
            ]);
    }
    public function ranges()
    {
        return auth()->user()->departments()->orderBy('fa_name')->pluck('fa_name', 'departments.id')->toArray();
    }
    public function uriKey()
    {
        return 'empolyee-trends';
    }
    public function name(): array|string|null
    {
        return __('Registered Employee');
    }
}
