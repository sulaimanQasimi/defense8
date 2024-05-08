<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class District extends Resource
{
    public static $model = \App\Models\District::class;
    public static $title = 'name';
    public static $search = [
        'name','code'
    ];
    public static function label()
    {
        return __('Districts');
    }

    public static function singularLabel()
    {
        return __('District');
    }
    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(trans("Province"),'province',Province::class)->searchable(),
            Text::make(trans("Name"), 'name')
                ->required()
                ->creationRules('required', 'unique:districts,name')
                ->updateRules('required', 'unique:districts,name,{{resourceId}}'),

            Text::make(trans("Code"), 'code')
                ->required()
                ->creationRules('required', 'unique:districts,code')
                ->updateRules('required', 'unique:districts,code,{{resourceId}}'),

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
