<?php

namespace Sq\Employee\Http\Controllers;

use App\Http\Controllers\Attendance\Report;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\Department;
use Sq\Employee\Document\PersonalInfo;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Sq\Query\Policy\UserDepartment;

class EmployeeInfoPDF
{

    public function info(CardInfo $cardInfo): void
    {
        if (!in_array($cardInfo->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }
        (new PersonalInfo())
            ->maker(employee: $cardInfo)
            ->download();
    }
    public function department(Department $department): void
    {

        if (!in_array($department->id, UserDepartment::getUserDepartment())) {
            abort(404);
        }

        $info = new PersonalInfo();
        foreach ($department->card_infos as $employee) {
            $info->maker(employee: $employee);
        }
        $info->download();
    }

}
