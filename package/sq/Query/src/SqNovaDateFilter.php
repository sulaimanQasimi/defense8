<?php

namespace Sq\Query;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateFilter\PersianDateFilter;

class SqNovaDateFilter extends PersianDateFilter
{
    public function __construct(public $column, public $label)
    {

    }
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->whereDate($this->column, $value);
    }
    public function name()
    {
        return $this->label;
    }
    public function key()
    {
        return 'sq_date_filter_'.$this->column;
    }

}
