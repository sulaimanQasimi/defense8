<?php

namespace Sq\Guest\Nova;

use App\Nova\Resource;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Employee\Nova\Gate;
use Sq\Query\Policy\UserDepartment;

class PatientGatePass extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\Sq\Guest\Models\PatientGatePass>
     */
    public static $model = \Sq\Guest\Models\PatientGatePass::class;

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
        'id',
    ];

    public static function label()
    {
        return __('مریضان داخل شده');
    }

    public static function singularLabel()
    {
        return __('مریضان داخل شده');
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if (auth()->user()->hasRole('super-admin')) {
            return $query;
        }

        if (auth()->user()->host) {
            return $query->whereHas('patient', function ($query) {
                $query->where('host_id', auth()->user()->host->id);
            })->orderBy('created_at', 'desc');
        }

        if (auth()->user()->can('gateChecker', 'App\\Models\Gate')) {
            return $query
                ->whereDate('created_at', now())
                ->orderBy('created_at', 'desc')
                ->whereHas('patient.host', function ($query) {
                    return $query->whereIn('department_id', UserDepartment::getUserDepartment());
                });
        }

        return $query->whereHas('patient.host', function ($query) {
            return $query->whereIn('department_id', UserDepartment::getUserDepartment());
        });
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

            BelongsTo::make(__('Patient'), 'patient', Patient::class)
                ->sortable(),

            BelongsTo::make(__('Gate'), 'gate', Gate::class)
                ->sortable(),

            DateTime::make(__('Entered At'), 'entered_at')
                ->sortable(),

            DateTime::make(__('Exit At'), 'exit_at')
                ->sortable(),
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

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'patient-gate-passes';
    }
}
