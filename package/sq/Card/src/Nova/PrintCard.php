<?php

namespace Sq\Card\Nova;

use Afj95\LaravelNovaHijriDatepickerField\HijriDatePicker;
use App\Nova\Resource;
use App\Nova\User;
use Coroowicaksono\ChartJsIntegration\LineChart;
use Coroowicaksono\ChartJsIntegration\ScatterChart;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use Sq\Employee\Nova\CardInfo;
use Sq\Query\Policy\UserDepartment;

class PrintCard extends Resource
{
    public static $model = \Sq\Card\Models\PrintCard::class;
    public static $title = 'card_info.registare_no';

    public static $search = [
        'card_info.registare_no',
    ];

    public static function label()
    {
        return __('Print Card');
    }
    public static function singularLabel()
    {
        return __('Print Card');
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (auth()->user()->hasRole('super-admin')) {
            return $query;
        }
        return $query->whereHas('card_info', function ($query) {
            return $query->whereIn('department_id', UserDepartment::getUserDepartment());
        });
    }

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(trans("Employee"), 'card_info', CardInfo::class),
            Text::make(trans("Department"), fn()=>$this->card_info?->orginization?->fa_name),

            BelongsTo::make(trans("User"), 'user', User::class),

            BelongsTo::make(trans("Card Type"), 'printCardFrame', PrintCardFrame::class),

            BelongsTo::make(trans("Paper Card"), 'customPaperCard', CustomPaperCard::class),

            HijriDatePicker::make(trans("Issue Date"), 'issue')->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom'),
            HijriDatePicker::make(trans("Expire Date"), 'expire')->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom'),
        ];
    }
    public function cards(NovaRequest $request)
    {
        $currentYear = verta()->year;
        $startDate = verta()->startYear()->datetime();
        $endDate = verta()->endYear()->datetime();

        $printData = static::$model::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($item) {
                $v = verta($item->created_at);
                return $v->format('n'); // Get month number (1-12)
            })
            ->map(function ($group) {
                return $group->count();
            })
            ->sortKeys(); // Sort by month number

        return [
            new Metrics\PrintCardMetric(),
            new Metrics\PrintCardFrameMetric(),
            (new LineChart)
                ->title(trans('جدول کارت های پرنت شده') . $currentYear)
                ->series([
                    [
                        'label' => trans('کارت های پرنت شده'),
                        'backgroundColor' => '#4099DE',
                        'borderColor' => '#4099DE',
                        'fill' => false,
                        'data' => $printData->values()->toArray()
                    ]
                ])
                ->options([
                    'responsive' => true,
                    'maintainAspectRatio' => false,
                    'xaxis' => ['categories' => $printData->keys()->toArray()],
                    'scales' => [
                        'y' => [
                            'beginAtZero' => true,
                            'title' => [
                                'display' => true,
                                'text' => trans('تعداد کارت')
                            ]
                        ],
                        'x' => [
                            'title' => [
                                'display' => true,
                                'text' => trans('ماه')
                            ]
                        ]
                    ]
                ])
        ];
    }
    public function filters(NovaRequest $request)
    {
        return [];
    }
    public function lenses(NovaRequest $request)
    {
        return [];
    }
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
