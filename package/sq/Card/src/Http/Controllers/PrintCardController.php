<?php

namespace Sq\Card\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Card\CardInfo;
use App\Models\Card\EmployeeVehicalCard;
use Sq\Card\Models\PrintCardFrame;
use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Sq\Card\Support\PrintCardField;

class PrintCardController
{
    public function employee(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
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
    public function gun(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::Gun) {
            abort(404);
        }
        app()->setLocale('fa');
        // Get / Replace the field to Value
        $field = new PrintCardField($cardInfo, $card);
        $details = $field->details;
        $remark = $field->remark;
        return view(($card->dim === "vertical") ? 'sqcard::print.card-vertical' : 'sqcard::print.card-horizontal', compact('cardInfo', 'card', 'details', 'remark'));

    }

    public function employee_car(Request $request, EmployeeVehicalCard $employeeVehicalCard, int $printCardFrame): View
    {
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
