<?php

namespace App\Nova\Card;

use App\Nova\Actions\EmployeePrintCardAction;
use App\Nova\Resource;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;

class MainCard extends Resource
{
    public static $model = \App\Models\Card\MainCard::class;

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
            PersianDate::make(__("Preform Date"),"card_perform"),
            PersianDate::make(__("Expire Date"),"card_expired_date"),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            (new EmployeePrintCardAction)->onlyOnDetail()->canRun(fn()=>auth()->user()->hasRole("Print Card"))
        ];
    }
}
