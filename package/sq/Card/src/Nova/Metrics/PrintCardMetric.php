<?php

namespace Sq\Card\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Sq\Card\Models\PrintCard;
use Sq\Query\Policy\UserDepartment;

class PrintCardMetric extends Value
{
    public function name()
    {
        return __('Print Card Count');
    }

    public function calculate(NovaRequest $request)
    {
        $query = PrintCard::query();

        if (!auth()->user()->hasRole('super-admin')) {
            $query->whereHas('card_info', function ($query) {
                return $query->whereIn('department_id', UserDepartment::getUserDepartment());
            });
        }

        if ($request->has('department_id')) {
            $query->whereHas('card_info', function ($query) use ($request) {
                return $query->where('department_id', $request->department_id);
            });
        }

        return $this->count($request, $query);
    }

    public function ranges()
    {
        return [
            30 => __('30 Days'),
            60 => __('60 Days'),
            365 => __('365 Days'),
            'TODAY' => __('Today'),
            'MTD' => __('Month To Date'),
            'QTD' => __('Quarter To Date'),
            'YTD' => __('Year To Date'),
        ];
    }

    public function uriKey()
    {
        return 'print-card-metric';
    }
}