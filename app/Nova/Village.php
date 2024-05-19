<?php

namespace App\Nova;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Village extends Resource
{
    public static $model = \App\Models\Village::class;
    public static $title = 'name';
    public static $search = [
        'name','code','province.name','district.name'
    ];

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(trans("Province"), 'province', Province::class)->searchable(),
            
            BelongsTo::make(trans("District"), 'district', District::class)
            ->dependsOn(
                ['province'],
                function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                    $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                        $query->where('province_id', $formData->province);
                    });
                }
            ),
            Text::make(trans("Name"), 'name')
                ->required()
                ->creationRules('required', 'unique:districts,name')
                ->updateRules('required', 'unique:districts,name,{{resourceId}}'),

            // Text::make(trans("Code"), 'code')
            //     ->required()
            //     ->creationRules('required', 'unique:districts,code')
            //     ->updateRules('required', 'unique:districts,code,{{resourceId}}'),

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
