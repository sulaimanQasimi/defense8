<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Province extends Resource
{
    public static $model = \App\Models\Province::class;
    public static $title = 'name';
    public static $search = [
        'name',
        'code'
    ];

    public static function label()
    {
        return __('Provinces');
    }

    public static function singularLabel()
    {
        return __('Province');
    }
    public function fields(NovaRequest $request)
    {
        return [
            Text::make(trans("Name"), 'name')
                ->required()
                ->creationRules('required', 'unique:provinces,name')
                ->updateRules('required', 'unique:provinces,name,{{resourceId}}'),

            // Text::make(trans("Code"), 'code')
            //     ->required()
            //     ->creationRules('required', 'unique:provinces,code')
            //     ->updateRules('required', 'unique:provinces,code,{{resourceId}}'),
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
