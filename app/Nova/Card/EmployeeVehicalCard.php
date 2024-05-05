<?php
namespace App\Nova\Card;

use App\Nova\Actions\EmployeeCarPrintCardAction;
use App\Nova\Card\Support\VehicalDriverField;
use App\Nova\Resource;
use Laravel\Nova\Http\Requests\NovaRequest;

class EmployeeVehicalCard extends Resource
{

    use VehicalDriverField;
    public static $model = \App\Models\Card\EmployeeVehicalCard::class;
    public static $title = 'id';
    public static $search = [
        'id',
    ];

    public static function label()
    {
        return __('Employee Vehical Card');
    }

    public static function singularLabel()
    {
        return __('Employee Vehical Card');
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
            (new EmployeeCarPrintCardAction)->onlyOnDetail()->canRun(fn()=>auth()->user()->hasRole("Print Card"))
        ];
    }
}
