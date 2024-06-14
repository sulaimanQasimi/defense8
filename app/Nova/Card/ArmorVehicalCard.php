<?php

namespace App\Nova\Card;

use App\Nova\Actions\ArmorCarPrintCardAction;
use App\Nova\Card\Support\VehicalDriverField;
use App\Nova\Resource;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;

class ArmorVehicalCard extends Resource
{
    use VehicalDriverField;
    public static $model = \App\Models\Card\ArmorVehicalCard::class;

    public static $title = 'vehical_palete';
    public static $search = [
        'vehical_type',
        "vehical_colour",
        "vehical_palete",

    ];

    public static function label()
    {
        return __('Armor Vehical Card');
    }

    public static function singularLabel()
    {
        return __('Armor Vehical Card');
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
            (new ArmorCarPrintCardAction)->onlyOnDetail()->canRun(fn()=>auth()->user()->hasRole("Print Card"))
        ];
    }
}
