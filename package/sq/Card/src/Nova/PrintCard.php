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
use MZiraki\PersianDateField\PersianDateTime;
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

            PersianDateTime::make(trans("زمان پرنت"), 'created_at'),
        ];
    }
    public function cards(NovaRequest $request)
    {
        return [
            new Metrics\PrintCardMetric(),
            new Metrics\PrintCardFrameMetric(),
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
