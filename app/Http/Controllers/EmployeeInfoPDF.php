<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Attendance\Report;
use App\Models\Card\CardInfo;
use App\Models\Department;
use App\Report\Document\PersonalInfo;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;

class EmployeeInfoPDF extends Controller
{

    public function info(CardInfo $cardInfo): void
    {
        (new PersonalInfo())
            ->maker(employee: $cardInfo)
            ->download();
    }
    public function department(Department $department): void
    {
        $info = new PersonalInfo();
        foreach ($department->card_infos as $employee) {
            $info->maker(employee: $employee);
        }
        $info->download();
    }

}
