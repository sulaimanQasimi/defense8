<?php

namespace Sq\Card\Http\Controllers;

use App\Http\Controllers\Controller;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\EmployeeVehicalCard;
use Sq\Card\Models\PrintCardFrame;
use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Sq\Card\Support\PrintCardField;
use Sq\Employee\Models\GunCard;
use Sq\Query\Policy\UserDepartment;

class PrintCardController
{
    public function employee(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        if (!in_array($cardInfo->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::Employee) {
            abort(404);
        }
        app()->setLocale('fa');
        // Get / Replace the field to Value
        $field = new PrintCardField($cardInfo, $card);
        $details = $field->details;
        $remark = $field->remark;
        return view(($card->dim === "vertical") ? 'sqcard::print.card-vertical' : 'sqcard::print.card-horizontal', compact('cardInfo', 'card', 'details', 'remark'));

    }
    public function gun(Request $request, GunCard $gunCard, int $printCardFrame): View
    {

        if (!in_array($gunCard->card_info->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }

        $card = PrintCardFrame::findOrFail($printCardFrame);
        $cardInfo = $gunCard->card_info;
        if (!$card->type == PrintTypeEnum::Gun) {
            abort(404);
        }
        app()->setLocale('fa');

        // Get / Replace the field to Value
        $field = new PrintCardField($gunCard->card_info, $card, null, $gunCard);
        $details = $field->details;
        $remark = $field->remark;

        return view(($card->dim === "vertical") ? 'sqcard::print.card-vertical' : 'sqcard::print.card-horizontal', compact('cardInfo', 'card', 'details', 'remark'));

    }

    public function employee_car(Request $request, EmployeeVehicalCard $employeeVehicalCard, int $printCardFrame): View
    {

        if (!in_array($employeeVehicalCard->card_info->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }


        $card = PrintCardFrame::findOrFail($printCardFrame);

        if (!$card->type == PrintTypeEnum::EmployeeCar) {
            abort(404);
        }

        app()->setLocale('fa');

        // Get / Replace the field to Value
        $field = new PrintCardField($employeeVehicalCard->card_info, $card, $employeeVehicalCard);
        $details = $field->details;
        $remark = $field->remark;
        $cardInfo = $employeeVehicalCard->card_info;
        return view(($card->dim === "vertical") ? 'sqcard::print.card-vertical' : 'sqcard::print.card-horizontal', compact('cardInfo', 'card', 'details', 'remark'));
    }
}
