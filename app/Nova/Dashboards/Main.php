<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\EmpolyeeTrends;
use App\Nova\Metrics\GuestCount;
use App\Nova\Metrics\GunTrends;
use App\Nova\Metrics\PresentEmployeeMetric;
use App\Nova\Metrics\TodayEnterGuestMetric;
use App\Nova\Metrics\TodayExitEmployeeMetric;
use App\Nova\Metrics\TodayExitGuestMetric;
use App\Nova\Metrics\TodayGuest;
use App\Nova\Metrics\TodayPresentEmployee;
use Coroowicaksono\ChartJsIntegration\DoughnutChart;
use Coroowicaksono\ChartJsIntegration\LineChart;
use Coroowicaksono\ChartJsIntegration\ScatterChart;
use Coroowicaksono\ChartJsIntegration\StackedChart;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
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
        $host = DB::table('hosts')->select(
            DB::raw('count(id) as num,year(created_at) as year')
        )->groupByRaw("year(created_at)")
            ->orderBy('year')
            ->pluck('num', 'year');
        return [
            GuestCount::make()->icon('academic-cap'),
            new EmpolyeeTrends,
            new GunTrends,
            new TodayGuest,
            new PresentEmployeeMetric,
            new TodayExitEmployeeMetric,
            TodayEnterGuestMetric::make()->icon('login'),
            TodayExitGuestMetric::make()->icon('logout'),
            TodayPresentEmployee::make(),
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
                    ]),
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
                    ]),

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


    public function name()
    {
        return __('Dashboard');

    }
}
