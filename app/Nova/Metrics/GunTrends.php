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

        return $this->count($request, GunCard::class);
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
        return [

            'ALL' => Nova::__('All'),
            30 => Nova::__('30 Days'),
            60 => Nova::__('60 Days'),
            90 => Nova::__('90 Days'),
        ];
    }
}
