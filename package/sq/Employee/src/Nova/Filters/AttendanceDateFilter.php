<?php

namespace Sq\Employee\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateFilter\PersianDateFilter;

class AttendanceDateFilter extends PersianDateFilter
{
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->whereDate('date', $value);
    }

    public function name(): string
    {
        return trans("Date");
    }

}
