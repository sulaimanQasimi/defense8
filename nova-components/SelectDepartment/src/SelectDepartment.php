<?php

namespace Acme\SelectDepartment;

use Laravel\Nova\Fields\Field;

class SelectDepartment extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'select-department';
}
