<?php

namespace Sq\Card\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Sq\Card\Models\PrintCard;
use Sq\Query\Policy\UserDepartment;
use Laravel\Nova\WithIcon;
use Hekmatinasser\Verta\Verta;

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

        $range = $request->range;

        if ($range === 'TODAY') {
            $today = Verta::now()->startDay()->datetime();
            $query->whereDate('created_at', '>=', $today);
        } elseif ($range === 'ALL') {
            // No date filtering for ALL
        } else {
            $days = intval($range);
            if ($days > 0) {
                $start = Verta::now()->subDays($days)->startDay()->datetime();
                $query->whereDate('created_at', '>=', $start);
            }
        }

        return $this->count($request, $query);
    }

    public function ranges()
    {
        $v = new Verta();
        return [
            30 => __(':count روز گذشته', ['count' => 30]),
            60 => __(':count روز گذشته', ['count' => 60]),
            365 => $v->format('%B %Y'),
            'TODAY' => __('امروز'),
            "ALL"=> __('همه'),
        ];
    }

    public function uriKey()
    {
        return 'print-card-metric';
    }
}
