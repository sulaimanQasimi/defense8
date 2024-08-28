<?php

namespace Acme\EmployeeAttendanceStatistic;

use Laravel\Nova\Card;

class EmployeeAttendanceStatistic extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/2';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'employee-attendance-statistic';
    }


    public function attentenceLabel(string $label,bool $present)
    {
        return $this->withMeta(['attentenceLabel' => $label,'present'=>$present]);
    }
}
