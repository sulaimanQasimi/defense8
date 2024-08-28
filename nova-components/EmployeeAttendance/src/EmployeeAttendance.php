<?php

namespace Acme\EmployeeAttendance;

use Laravel\Nova\ResourceTool;

class EmployeeAttendance extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name()
    {
        return 'Employee Attendance';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component()
    {
        return 'employee-attendance';
    }
}
