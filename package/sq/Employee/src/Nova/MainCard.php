<?php

namespace Sq\Employee\Nova;

use App\Nova\Actions\EmployeePrintCardAction;
use App\Nova\Resource;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;

class MainCard extends Resource
{
    public static $model = \Sq\Employee\Models\MainCard::class;

    public static $title = 'card_info.registare_no';

    public static $search = [
    ];

    public static function label()
    {
        return __('Main Card');
    }

    public static function singularLabel()
    {
        return __('Main Card');
    }


    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(__('info'),'card_info',CardInfo::class),
            PersianDate::make(__("Disterbute Date"),"card_perform"),
            PersianDate::make(__("Expire Date"),"card_expired_date"),
        ];
    }
    public function cards(NovaRequest $request)
    {
        return [];
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
        return [
            (new \Sq\Card\Nova\Actions\EmployeePrintCardAction)->onlyOnDetail()->canRun(fn()=>auth()->user()->hasRole("Print Card"))
        ];
    }
}
