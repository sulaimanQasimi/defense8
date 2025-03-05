<?php
namespace App\Nova\Dashboards;

use Coroowicaksono\ChartJsIntegration\LineChart;
use Coroowicaksono\ChartJsIntegration\ScatterChart;
use Coroowicaksono\ChartJsIntegration\StackedChart;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Dashboard;
use Laravel\Nova\Metrics\ApexLineChart;

class GraphDashboard extends Dashboard
{
    private const CHART_COLORS = [
        'primary' => '#f7a35c',
        'secondary' => '#1e31e4'
    ];

    private function getEmployeesByDepartment(): Collection
    {
        return collect(DB::table('card_infos')
            ->join('departments', 'departments.id', 'card_infos.department_id')
            ->select(DB::raw('count(card_infos.id) as num, departments.fa_name as name'))
            ->groupByRaw('departments.fa_name')
            ->orderBy('name')
            ->get(['num', 'name'])
            ->map(fn($employee) => [
                'x' => $employee->name,
                'y' => $employee->num
            ]));
    }

    private function getOilDistribution(): Collection
    {
        return collect(DB::table('oil_disterbutions')
            ->select(DB::raw('sum(oil_disterbutions.oil_amount) as num'))
            ->selectRaw('date(filled_date) as date')
            ->groupByRaw('date')
            ->orderBy('date')
            ->get(['num', 'date'])
            ->map(fn($oil) => [
                'x' => verta($oil->date)->format('Y/m/d'),
                'y' => $oil->num
            ]));
    }

    private function getDepartmentStats(): array
    {
        $query = fn(string $table): Builder => DB::table($table)
            ->join('departments', 'departments.id', "$table.department_id")
            ->select(DB::raw("count($table.id) as num, departments.fa_name as name"))
            ->groupByRaw('departments.fa_name')
            ->orderBy('name');

        return [
            'employees' => $query('card_infos')->pluck('num', 'name'),
            'gates' => $query('gates')->pluck('num', 'name')
        ];
    }

    private function getYearlyStats(): array
    {
        $yearlyQuery = fn(string $table): Collection => DB::table($table)
            ->select(DB::raw('count(id) as num, year(created_at) as year'))
            ->groupByRaw('year(created_at)')
            ->orderBy('year')
            ->pluck('num', 'year');

        return [
            'info' => $yearlyQuery('card_infos'),
            'host' => $yearlyQuery('hosts')
        ];
    }

    private function createTimeSeriesChart(string $title, array $data): LineChart
    {
        return (new LineChart)
            ->title($title)
            ->series([
                [
                    'barPercentage' => 0.5,
                    'label' => trans('Card Info'),
                    'borderColor' => self::CHART_COLORS['primary'],
                    'data' => $data['info']
                ],
                [
                    'barPercentage' => 0.5,
                    'label' => trans('Hosts'),
                    'borderColor' => self::CHART_COLORS['secondary'],
                    'data' => $data['host']
                ]
            ])
            ->options([
                'xaxis' => collect($data['info'])->keys()
            ]);
    }

    private function createDepartmentChart(array $data): LineChart
    {
        return (new LineChart)
            ->title(trans('Department'))
            ->series([
                [
                    'barPercentage' => 0.5,
                    'label' => trans('Employees'),
                    'borderColor' => self::CHART_COLORS['primary'],
                    'data' => $data['employees']
                ],
                [
                    'barPercentage' => 0.5,
                    'label' => trans('Gates'),
                    'borderColor' => self::CHART_COLORS['secondary'],
                    'data' => $data['gates']
                ]
            ])
            ->options([
                'xaxis' => collect($data['employees'])->keys()
            ]);
    }

    private function createTreemapChart(): ApexLineChart
    {
        return (new ApexLineChart())
            ->options([
                'chart' => [
                    'type' => 'treemap',
                    'animations' => [
                        'enabled' => true,
                        'easing' => 'easeinout',
                        'speed' => 800,
                        'animateGradually' => ['enabled' => true, 'delay' => 150],
                        'dynamicAnimation' => ['enabled' => true, 'speed' => 350]
                    ]
                ],
                'zoom' => ['enabled' => true],
                'plotOptions' => [
                    'treemap' => [
                        'colorScale' => [
                            'ranges' => [
                                ['from' => -6, 'to' => 0, 'color' => '#CD363A'],
                                ['from' => 0.001, 'to' => 6, 'color' => '#52B12C']
                            ]
                        ]
                    ]
                ],
                'series' => [['data' => $this->getEmployeesByDepartment()->toArray()]]
            ])
            ->width('1/2');
    }

    public function cards(): array
    {
        $yearlyStats = $this->getYearlyStats();
        $departmentStats = $this->getDepartmentStats();

        return [
            $this->createTimeSeriesChart('', $yearlyStats)->width('1/2'),
            (new StackedChart)
                ->title('')
                ->series([
                    ['barPercentage' => 0.5, 'label' => trans('Card Info'), 'backgroundColor' => self::CHART_COLORS['primary'], 'data' => $yearlyStats['info']],
                    ['barPercentage' => 0.5, 'label' => trans('Hosts'), 'backgroundColor' => self::CHART_COLORS['secondary'], 'data' => $yearlyStats['host']]
                ])
                ->options(['xaxis' => collect($yearlyStats['info'])->keys()])
                ->width('1/2'),
            (new ScatterChart)
                ->title('')
                ->series([
                    ['barPercentage' => 0.5, 'label' => trans('Card Info'), 'backgroundColor' => self::CHART_COLORS['primary'], 'data' => $yearlyStats['info']],
                    ['barPercentage' => 0.5, 'label' => trans('Hosts'), 'backgroundColor' => self::CHART_COLORS['secondary'], 'data' => $yearlyStats['host']]
                ])
                ->options(['xaxis' => collect($yearlyStats['info'])->keys()]),
            $this->createDepartmentChart($departmentStats),
            $this->createTreemapChart(),
            (new ApexLineChart())
                ->options([
                    'chart' => ['type' => 'donut'],
                    'plotOptions' => ['bar' => []],
                    'series' => $this->getEmployeesByDepartment()->map(fn($e) => $e['y'])->toArray(),
                    'labels' => $this->getEmployeesByDepartment()->map(fn($e) => $e['x'])->toArray()
                ])
                ->width('1/2'),
            (new ApexLineChart())
                ->options([
                    'chart' => ['type' => 'area'],
                    'series' => [[
                        'name' => trans('Oil Disterbution'),
                        'data' => $this->getOilDistribution()->toArray()
                    ]]
                ])
                ->width('full'),
            $this->createEmployeeTimelineChart()
        ];
    }

    private function createEmployeeTimelineChart(): ApexLineChart
    {
        return (new ApexLineChart())
            ->options([
                'chart' => ['type' => 'area'],
                'series' => [[
                    'name' => trans('Employees'),
                    'data' => DB::table('card_infos')
                        ->select(DB::raw('count(id) as num, date(created_at) as year'))
                        ->groupByRaw('date(created_at)')
                        ->orderBy('year')
                        ->get(['num', 'year'])
                        ->map(fn($employee) => [
                            'x' => verta($employee->year)->format('Y/m/d'),
                            'y' => $employee->num
                        ])
                ]]
            ])
            ->width('full');
    }

    public function uriKey(): string
    {
        return 'graph-dashboard';
    }

    public function name(): string
    {
        return trans('Graph Dashboard');
    }
}
