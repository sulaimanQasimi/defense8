<?php
namespace Sq\Guest\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use MZiraki\PersianDateField\PersianDateTime;

class GuestGate extends Resource
{
    public static $model = \Sq\Guest\Models\GuestGate::class;

    public static $title = 'id';

    public static $search = [
        'id',
    ];

    public static function label()
    {
        return __('Gate Passed');
    }

    public static function singularLabel()
    {
        return __('Gate Passed');
    }
    public function fields(NovaRequest $request)
    {
        return [
            // Host
            BelongsTo::make(__("Gate"), 'gate', \Sq\Employee\Nova\Gate::class),

            // Host
            BelongsTo::make(__("Guest"), 'guest', Host::class),

            PersianDateTime::make(__("Enter"), "entered_at")
                ->required()
                ->rules('required', 'date')
                ->placeholder(__("Enter Field", ['name' => __("Enter")])),
            PersianDateTime::make(__("Exited"), "exit_at")
                ->required()
                ->rules('required', 'date')
                ->placeholder(__("Enter Field", ['name' => __("Exited")])),


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
