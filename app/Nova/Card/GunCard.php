<?php
namespace App\Nova\Card;

use App\Nova\Resource;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;

class GunCard extends Resource
{

    public static $model = \App\Models\Card\GunCard::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static function label()
    {
        return __('Gun Card');
    }

    public static function singularLabel()
    {
        return __('Gun Card');
    }



    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(__('Info'), 'card_info', CardInfo::class),
            Text::make(__("Gun Type"), "gun_type")
                ->required()
                ->rules("required", "string"),
            Text::make(__("Gun No"), "gun_no")
                ->required()
                ->creationRules("required", "string", "unique:gun_cards,gun_no")
                ->updateRules("required", "string", "unique:gun_cards,gun_no,{{resourceId}}"),
            Text::make(__("Gun Range"), "range")
                ->required()
                ->rules("required", "string"),
            PersianDate::make(__("Filled Form Date"), "filled_form_date")
                ->required()
                ->rules("required", "date"),
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
        return [];
    }
}
