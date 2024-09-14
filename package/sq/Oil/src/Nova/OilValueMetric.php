<?php

namespace Sq\Oil\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;
use Sq\Query\OilStatistics;
use Vehical\OilType;

class OilValueMetric extends Value
{
    public function __construct(private $oilType)
    {

    }

    public function calculate(NovaRequest $request)
    {

        $statistic = (new OilStatistics())->make();
        $result = match ($request->input('range')) {
            'current_month_import' => $statistic['current_month']['import'][$this->oilType],
            'current_month_export' => $statistic['current_month']['export'][$this->oilType],
            'current_month_remain' => $statistic['current_month']['remain'][$this->oilType],
            'past_month_import' => $statistic['past_month']['import'][$this->oilType],
            'past_month_export' => $statistic['past_month']['export'][$this->oilType],
            'past_month_remain' => $statistic['past_month']['remain'][$this->oilType],
        };

        return $this->result($result)->format([
            'thousandSeparated' => true,
            'mantissa' => 0,
        ])->suffix(trans("Liter", ['value' => '']));
    }

    public function ranges()
    {
        return [
            'current_month_import' => trans("Month Action", ['name' => __("Current Month"), 'type' => __($this->oilType), 'action' => trans("Import")]),
            'current_month_export' => trans("Month Action", ['name' => __("Current Month"), 'type' => __($this->oilType), 'action' => trans("Export")]),
            'current_month_remain' => trans("Month Action", ['name' => __("Current Month"), 'type' => __($this->oilType), 'action' => trans("Remain")]),
            'past_month_import' => trans("Month Action", ['name' => __("Past Month"), 'type' => __($this->oilType), 'action' => trans("Import")]),
            'past_month_export' => trans("Month Action", ['name' => __("Past Month"), 'type' => __($this->oilType), 'action' => trans("Export")]),
            'past_month_remain' => trans("Month Action", ['name' => __("Past Month"), 'type' => __($this->oilType), 'action' => trans("Remain")]),

        ];
    }
    public function cacheFor()
    {
        return now()->addMinutes(5);
    }
    public function name(): string
    {
        return trans($this->oilType);
    }
}
