<?php

namespace Sq\Query;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use Seoegypt\ValueFilter\ValueFilter;

class SqNovaTextFilter extends ValueFilter
{
    public $type = "text";

    public function __construct(public $column, public $label)
    {

    }
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->where($this->column, 'LIKE', "%{$value}%");
    }

    public function name()
    {
        return $this->label;
    }
    public function key()
    {
        return 'guest_filter_' . $this->column;
    }
}
