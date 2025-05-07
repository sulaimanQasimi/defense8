<?php

namespace Sq\Employee\Nova\Filters;

use Laravel\Nova\Filters\BooleanFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class ConfirmedFilter extends BooleanFilter
{
    /**
     * Apply the filter to the given query.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        if ($value['confirmed']) {
            return $query->where('confirmed', true);
        }

        if ($value['not_confirmed']) {
            return $query->where('confirmed', false);
        }

        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [
            __('Confirmed') => 'confirmed',
            __('Not Confirmed') => 'not_confirmed',
        ];
    }
}
