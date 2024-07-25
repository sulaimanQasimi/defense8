<?php

namespace App\Nova\Dashboards;

use Coroowicaksono\ChartJsIntegration\LineChart;
use Coroowicaksono\ChartJsIntegration\ScatterChart;
use Coroowicaksono\ChartJsIntegration\StackedChart;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Dashboard;
use Laravel\Nova\Metrics\ApexLineChart;

class GraphDashboard extends Dashboard
{
    public function apex_chart_emplyess_department()
    {

        return collect(DB::table('card_infos')
            ->join("departments", 'departments.id', 'card_infos.department_id')
            ->select(DB::raw('count(card_infos.id) as num,departments.fa_name as name'))
            ->groupByRaw("departments.fa_name")
            ->orderBy('name')
            ->get(['num', 'name'])->map(function ($employee) {
                // dd($employee);
                return [
                    "x" => $employee->name,
                    "y" => $employee->num
                ];
            }));
    }

    public function apex_chart_oil_disterbution()
    {

        return collect(DB::table('oil_disterbutions')
            // ->join("departments", 'departments.id', 'card_infos.department_id')
            ->select(DB::raw('sum(oil_disterbutions.oil_amount) as num'))
            ->selectRaw("date(filled_date) as date")
            ->groupByRaw("date")
            ->orderBy('date')

            ->get(['num', 'date'])->map(function ($oil) {
                // dd($oil);
                return [
                    "x" => verta($oil->date)->format("Y/m/d"),
                    "y" => $oil->num
                ];
            }));
    }








    public function cards()
    {
        $department_employee = DB::table('card_infos')
            ->join("departments", 'departments.id', 'card_infos.department_id')
            ->select(DB::raw('count(card_infos.id) as num,departments.fa_name as name'))
            ->groupByRaw("departments.fa_name")
            ->orderBy('name')
            ->pluck('num', 'name');

        $department_gate = DB::table('gates')
            ->join("departments", 'departments.id', 'gates.department_id')
            ->select(DB::raw('count(gates.id) as num,departments.fa_name as name'))
            ->groupByRaw("departments.fa_name")
            ->orderBy('name')
            ->pluck('num', 'name');


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

            (new LineChart)
                ->title(trans("Department"))
                ->series(
                    array(
                        [
                            'barPercentage' => 0.5,
                            'label' => trans("Employees"),
                            'borderColor' => "#f7a35c",
                            'data' => $department_employee
                        ],
                        [
                            'barPercentage' => 0.5,
                            'label' => trans("Gates"),
                            'borderColor' => "#1e31e4",
                            'data' => $department_gate
                        ]

                    )
                )
                ->options([
                    'xaxis' => collect($department_employee)->keys()
                ]),
            //


            (new ApexLineChart())
                ->options([

                    //
                    "chart" => [
                        // "height" => 350,
                        "type" => "treemap",
                        "animations" => [
                            "enabled" => true,
                            "easing" => 'easeinout',
                            "speed" => 800,
                            "animateGradually" => [
                                "enabled" => true,
                                "delay" => 150
                            ],
                            "dynamicAnimation" => [
                                "enabled" => true,
                                "speed" => 350
                            ]
                        ]
                    ],
                    // "theme" => [
                    //     "mode" => 'dark',
                    //     "palette" => 'palette6',

                    //     "monochrome" => [
                    //         "enabled" => true,
                    //         "color" => '#255aee',
                    //         "shadeTo" => 'light',
                    //         "shadeIntensity" => 0.65
                    //     ]
                    // ],
                    "zoom" => [
                        "enabled" => true
                    ],

                    "plotOptions" => [
                        "treemap" => [
                            "colorScale" => [
                                "ranges" => [
                                    [
                                        "from" => -6,
                                        "to" => 0,
                                        "color" => '#CD363A'
                                    ],
                                    [
                                        "from" => 0.001,
                                        "to" => 6,
                                        "color" => '#52B12C'
                                    ]
                                ]
                            ],
                        ],
                    ],
                    "series" => [
                        [
                            "data" => $this->apex_chart_emplyess_department()->toArray()
                        ],
                    ]
                ])->width('1/2'),

            (new ApexLineChart())
                ->options([
                    "chart" => [
                        "type" => 'donut',
                        // "height"=> 350,
                    ],
                    "plotOptions" => [
                        "bar" => [
                            //   "horizontal"=> true,
                            "isFunnel" => true,
                        ],
                    ],
                    "series" => $this->apex_chart_emplyess_department()->map(fn($e) => $e['y'])->toArray(),
                    "labels" => $this->apex_chart_emplyess_department()->map(fn($e) => $e['x'])->toArray()
                    //   "series"=> [
                    //     [
                    //       "name"=> "Funnel Series",
                    //       "data"=> $this->apex_chart_emplyess_department()/*->map(fn($e)=>['x'=>$e['y'],'y'=>$e['x']])*/->toArray()
                    //     ],
                    //   ]

                ])->width("1/2"),
            (new ApexLineChart())
                ->options([
                    "chart" => [
                        "type" => "area",
                    ],

                    // "plotOptions" => [
                    //     "bar" => [
                    //         // "horizontal" => true
                    //     ]
                    // ],
                    "series" => [
                        [
                            "name" => trans("Oil Disterbution"),
                            "data" => $this->apex_chart_oil_disterbution()->toArray()
                        ],
                    ],

                    // "xaxis" => [
                    //     "type" => 'category'
                    // ]
                ])->width('1/2'),






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
