<?php


namespace Sq\Query;

use Illuminate\Support\Arr;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class SqNovaSelectFilter extends Filter
{
    public $component = 'select-filter';

    public function __construct(private string $column, private string $label,private array $options)
    {

    }
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->where($this->column,$value);
    }
    public function options(NovaRequest $request)
    {
        return array_flip($this->options);
    }
    public function name()
    {
        return $this->label;
    }
    public function key()
    {
        return 'sq_select_filter_'.$this->column;
    }

}
