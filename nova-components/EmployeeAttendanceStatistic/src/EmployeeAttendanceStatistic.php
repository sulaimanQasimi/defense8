<?php

namespace Acme\EmployeeAttendanceStatistic;

use Laravel\Nova\Card;

class EmployeeAttendanceStatistic extends Card
{
    public $width = '1/2';
    public function component()
    {
        return 'employee-attendance-statistic';
    }
    public function attentenceLabel(string $label, bool $present)
    {
        return $this->withMeta(['attentenceLabel' => $label, 'present' => $present]);
    }
}
