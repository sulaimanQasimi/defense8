<?php

namespace Sq\Employee\Http\Controllers;

use Sq\Employee\Http\Controllers\Attendance\Report;
use Sq\Employee\Http\Controllers\Attendance\SingleEmployeeReport;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\Department;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Sq\Query\Policy\UserDepartment;

class CurrentMonthEmployeeAttendance
{
    public function single_employee($cardInfo)
    {
        return (new SingleEmployeeReport(id: $cardInfo))
            ->maker()
            ->download();
    }
    public function single_department($department)
    {
        return (new Report(department_id:$department))->maker()->download();
    }
}
