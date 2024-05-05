<?php
namespace App\Nova\Card;

use App\Nova\Actions\BlackMirrorCarPrintCardAction;
use App\Nova\Card\Support\VehicalDriverField;
use App\Nova\Resource;
use Laravel\Nova\Http\Requests\NovaRequest;

class BlackMirrorVehicalCard extends Resource
{

    use VehicalDriverField;
    public static $model = \App\Models\Card\BlackMirrorVehicalCard::class;
   public static $title = 'id';
    public static $search = [
        'id',
    ];


    public static function label()
    {
        return __('Black Mirror Vehical Card');
    }

    public static function singularLabel()
    {
        return __('Black Mirror Vehical Card');
    }



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
            (new BlackMirrorCarPrintCardAction)->onlyOnDetail()->canRun(fn()=>auth()->user()->hasRole("Print Card"))

        ];
    }
}
