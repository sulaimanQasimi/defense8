<?php

namespace Sq\Fingerprint\Nova\Resources;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Fingerprint\Nova\Fields\Fingerprint;
use Sq\Fingerprint\Models\BiometricData as BiometricDataModel;

class BiometricData extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = BiometricDataModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'record_id', 'Manufacturer', 'Model', 'SerialNumber',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Biometric Data');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Biometric Data');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Number::make('Record ID', 'record_id')
                ->rules('required', 'numeric')
                ->sortable(),

            Text::make('Manufacturer')
                ->nullable()
                ->hideFromIndex(),

            Text::make('Model')
                ->nullable()
                ->hideFromIndex(),

            Text::make('Serial Number', 'SerialNumber')
                ->nullable()
                ->hideFromIndex(),

            Number::make('Image Width', 'ImageWidth')
                ->nullable()
                ->hideFromIndex(),

            Number::make('Image Height', 'ImageHeight')
                ->nullable()
                ->hideFromIndex(),

            Number::make('Image DPI', 'ImageDPI')
                ->nullable()
                ->hideFromIndex(),

            Number::make('Image Quality', 'ImageQuality')
                ->nullable()
                ->hideFromIndex(),

            Number::make('NFIQ')
                ->nullable()
                ->hideFromIndex(),

            Fingerprint::make('Fingerprint Template', 'ISOTemplateBase64')
                ->height(300)
                ->width(300)
                ->quality(80)
                ->debug(false)
                ->hideFromIndex()
                ->rules('nullable', 'string'),

            DateTime::make('Created At')
                ->onlyOnDetail(),

            DateTime::make('Updated At')
                ->onlyOnDetail(),
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
