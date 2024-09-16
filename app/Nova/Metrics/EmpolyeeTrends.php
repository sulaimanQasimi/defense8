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
        return $this->count($request, CardInfo::class);
    }
    public function ranges()
    {
        return [
            'ALL' => Nova::__('All'),
            30 => Nova::__('30 Days'),
            60 => Nova::__('60 Days'),
            90 => Nova::__('90 Days'),
        ];
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
