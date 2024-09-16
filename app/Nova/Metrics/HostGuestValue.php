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
        return $this->count($request, Guest::query());
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
