<?php

namespace Sq\Card\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Sq\Card\Models\PrintCard;
use Sq\Query\Policy\UserDepartment;
use Laravel\Nova\WithIcon;

class PrintCardMetric extends Value
{
    public $icon= 'fa-solid fa-id-card';


    public function name()
    {
        return __('تعداد کارت های چاپ شده');
    }

    public function calculate(NovaRequest $request)
    {
        $query = PrintCard::query();

        // if (!auth()->user()->hasRole('super-admin')) {
        //     $query->whereHas('card_info', function ($query) {
        //         return $query->whereIn('department_id', UserDepartment::getUserDepartment());
        //     });
        // }

        // if ($request->has('department_id')) {
        //     $query->whereHas('card_info', function ($query) use ($request) {
        //         return $query->where('department_id', $request->department_id);
        //     });
        // }

        return $this->count($request, $query);
    }

    public function ranges()
    {
        return [
            30 => __('30 Days'),
            60 => __('60 Days'),
            365 => __('امسال'),
            'TODAY' => __('امروز'),
            "ALL"=> __('همه'),
        ];
    }

    public function uriKey()
    {
        return 'print-card-metric';
    }
}
