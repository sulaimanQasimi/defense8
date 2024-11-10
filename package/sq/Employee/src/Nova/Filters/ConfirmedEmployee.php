<?php

namespace Sq\Employee\Nova\Filters;

use Laravel\Nova\Filters\BooleanFilter;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class ConfirmedEmployee extends Filter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->where('confirmed', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [

            __('Confirmed') => 0,
            __('Unknown Employee') => 1,
        ];
    }
    public function key()
    {
        return 'sq-confirmed-filter';
    }
    public function name()
    {
        return __("Confirm Employee");
    }
}
