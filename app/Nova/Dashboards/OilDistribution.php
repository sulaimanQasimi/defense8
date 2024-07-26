<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\ExpendDiesel;
use App\Nova\Metrics\ExpendPetrol;
use App\Nova\Metrics\RemainDiesel;
use App\Nova\Metrics\RemainPetrol;
use Coroowicaksono\ChartJsIntegration\LineChart;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Dashboard;
use Laravel\Nova\Metrics\ApexLineChart;
use Number;
use Support\Defense;
use Vehical\OilType;

class OilDistribution extends Dashboard
{
    public function apex_chart_oil_disterbution_consume($oilType)
    {
        return collect(DB::table('oil_disterbutions')
            // ->join("departments", 'departments.id', 'card_infos.department_id')
            ->where("oil_type", $oilType)
            ->select(DB::raw('sum(oil_disterbutions.oil_amount) as num'))
            ->whereBetween('filled_date', [Defense::start_of_month(), Defense::end_of_month()])
            ->selectRaw("date(filled_date) as date")
            ->groupByRaw("date")
            ->orderBy('date')
            ->get(['num', 'date'])
            ->map(function ($oil) {
                return [
                    "x" => verta($oil->date)->format("Y/m/d"),
                    "y" => $oil->num
                ];
            }));
    }







    public function graph()
    {
        return
            (new ApexLineChart())
                ->options([
                    "chart" => [
                        "height"=>400,
                        "type" => "area",
                    ],
                    "series" => [
                        [
                            // "type"=> 'line',
                            "name" => trans("Diesel"),
                            "data" => $this->apex_chart_oil_disterbution_consume(OilType::Diesel)->toArray()
                        ],

                        [
                            "name" => trans("Petrole"),
                            "data" => $this->apex_chart_oil_disterbution_consume(OilType::Petrole)->toArray()
                        ],
                    ],

                    "xaxis" => [
                        "type" => 'category',
                        // "categories" => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                    ]
                ])->width('full');
    }
    public function cards()
    {
        return [
            RemainPetrol::make()->icon('fas fa-charging-station fa-2x '),
            RemainDiesel::make()->icon('fas fa-gas-pump fa-2x'),
            ExpendPetrol::make()->icon('fas fa-charging-station fa-2x'),
            ExpendDiesel::make()->icon('fas fa-gas-pump fa-2x'),
            $this->graph()

        ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */

    public function uriKey()
    {
        return 'oil-distribution';
    }
    public function name()
    {
        return trans("Dashboard");
    }
}
