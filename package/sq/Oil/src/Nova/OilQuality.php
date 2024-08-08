<?php

namespace Sq\Oil\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Vehical\OilType;

class OilQuality extends Resource
{
    public static $model = \Sq\Oil\Models\OilQuality::class;
    public static $title = 'name';
    public static $search = [
        'name',
    ];

    public static function label()
    {
        return __('Oil Quality');
    }

    public static function singularLabel()
    {
        return __('Oil Quality');
    }
    public function fields(NovaRequest $request)
    {
        return [
            Fields\Text::make(trans("Name"), 'name')
                ->creationRules('required', 'string')
                ->updateRules('required', 'string'),
            Fields\Select::make(trans("Oil Type"), 'oil_type')
                ->options([
                    OilType::Diesel => trans("Diesel"),
                    OilType::Petrole => trans("Petrole"),
                ])
                ->rules('required', Rule::in([OilType::Diesel, OilType::Petrole]))
                ->filterable()
                ->displayUsingLabels(),
                Fields\HasMany::make(trans("Oil"),'oil',Oil::class),
        ];
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
        return [];
    }
}
