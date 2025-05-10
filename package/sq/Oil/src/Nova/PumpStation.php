<?php

namespace Sq\Oil\Nova;

use App\Nova\Resource;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Query\SqNovaNumberFilter;
use Sq\Query\SqNovaSelectFilter;
use Sq\Query\SqNovaTextFilter;

class PumpStation extends Resource
{
    use MegaFilterTrait;
    use Authorizable;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Sq\Oil\Models\PumpStation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'location',
        'address',
    ];

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Pump Stations');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Pump Station');
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

            Text::make(__('Name'), 'name')
                ->rules('required', 'max:255')
                ->sortable(),

            BelongsTo::make(__('Manager'), 'user', \App\Nova\User::class)
                ->nullable()
                ->searchable(),

            Text::make(__('Location'), 'location')
                ->rules('nullable', 'max:255')
                ->hideFromIndex(),

            Textarea::make(__('Address'), 'address')
                ->rules('nullable')
                ->hideFromIndex(),

            Text::make(__('Contact Number'), 'contact_number')
                ->rules('nullable', 'max:50')
                ->hideFromIndex(),

            Number::make(__('Capacity (Liters)'), 'capacity')
                ->rules('nullable', 'integer', 'min:0')
                ->sortable(),

            Boolean::make(__('Active'), 'is_active')
                ->default(true)
                ->sortable(),

            Textarea::make(__('Notes'), 'notes')
                ->rules('nullable')
                ->hideFromIndex(),

            HasMany::make(__('Oils'), 'oils', Oil::class),

            HasMany::make(__('Oil Distributions'), 'oilDistributions', OilDisterbution::class),
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
        return [
            MegaFilter::make([
                new SqNovaTextFilter(label: __('Name'), column: 'name'),
                new SqNovaTextFilter(label: __('Location'), column: 'location'),
                new SqNovaNumberFilter(label: __('Capacity'), column: 'capacity'),
                new SqNovaSelectFilter(label: __('Active'), column: 'is_active', options: [
                    1 => __('Yes'),
                    0 => __('No'),
                ]),
            ])->columns(3)
        ];
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
