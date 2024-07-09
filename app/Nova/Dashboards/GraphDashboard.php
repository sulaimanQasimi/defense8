<?php

namespace App\Nova\Dashboards;

use Coroowicaksono\ChartJsIntegration\LineChart;
use Coroowicaksono\ChartJsIntegration\ScatterChart;
use Coroowicaksono\ChartJsIntegration\StackedChart;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Dashboard;

class GraphDashboard extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {

        //
        $info = DB::table('card_infos')->select(
            DB::raw('count(id) as num,year(created_at) as year')
        )->groupByRaw("year(created_at)")
            ->orderBy('year')
            ->pluck('num', 'year');


        //
        $host = DB::table('hosts')
            ->select(
                DB::raw('count(id) as num,year(created_at) as year')
            )->groupByRaw("year(created_at)")
            ->orderBy('year')
            ->pluck('num', 'year');

        return [

            (new LineChart)
                ->title("")
                ->series(
                    array(
                        [
                            'barPercentage' => 0.5,
                            'label' => trans("Card Info"),
                            'borderColor' => "#f7a35c",
                            'data' => $info
                        ],
                        [
                            'barPercentage' => 0.5,
                            'label' => trans("Hosts"),
                            'borderColor' => "#1e31e4",
                            'data' => $host
                        ]

                    )
                )->options([
                        'xaxis' => collect($info)->keys()
                    ])->width("1/2"),
            (new StackedChart)
                ->title("")
                ->series(
                    array(
                        [
                            'barPercentage' => 0.5,
                            'label' => trans("Card Info"),
                            'backgroundColor' => "#f7a35c",
                            'data' => $info
                        ],
                        [
                            'barPercentage' => 0.5,
                            'label' => trans("Hosts"),
                            'backgroundColor' => "#1e31e4",
                            'data' => $host
                        ]

                    )
                )->options([
                        'xaxis' => collect($info)->keys()
                    ])->width("1/2"),

            (new ScatterChart)
                ->title("")
                ->series(
                    array(
                        [
                            'barPercentage' => 0.5,
                            'label' => trans("Card Info"),
                            'backgroundColor' => "#f7a35c",
                            'data' => $info
                        ],
                        [
                            'barPercentage' => 0.5,
                            'label' => trans("Hosts"),
                            'backgroundColor' => "#1e31e4",
                            'data' => $host
                        ]

                    )
                )->options([
                        'xaxis' => collect($info)->keys()
                    ]),

        ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'graph-dashboard';
    }
    public function name()
    {
        return trans("Graph Dashboard");
    }
}
