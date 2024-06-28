<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Card\CardInfo;
use App\Models\Card\EmployeeVehicalCard;
use App\Models\PrintCardFrame;
use App\Support\Defense\Print\PrintTypeEnum;
use Card\PrintCardField;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrintCardController extends Controller
{
    public function employee(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::Employee) {
            return abort(404);
        }
        app()->setLocale('fa');
        // Get / Replace the field to Value
        $field = new PrintCardField($cardInfo, $card);
        $details = $field->details;
        $remark = $field->remark;
        return view(($card->dim === "vertical") ? 'employee.print.card-vertical' : 'employee.print.card-horizontal', compact('cardInfo', 'card', 'details', 'remark'));

    }
    public function gun(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::Gun) {
            return abort(404);
        }
        app()->setLocale('fa');
        // Get / Replace the field to Value
        $field = new PrintCardField($cardInfo, $card);
        $details = $field->details;
        $remark = $field->remark;
        return view(($card->dim === "vertical") ? 'employee.print.card-vertical' : 'employee.print.card-horizontal', compact('cardInfo', 'card', 'details', 'remark'));

    }

    public function employee_car(Request $request, EmployeeVehicalCard $employeeVehicalCard, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::EmployeeCar) {
            return abort(404);
        }

        app()->setLocale('fa');
        // Get / Replace the field to Value
        $field = new PrintCardField($employeeVehicalCard->card_info, $card,$employeeVehicalCard);
        $details = $field->details;
        $remark = $field->remark;
        $cardInfo=$employeeVehicalCard->card_info;
        return view(($card->dim === "vertical") ? 'employee.print.card-vertical' : 'employee.print.card-horizontal', compact('cardInfo', 'card', 'details', 'remark'));
    }
}
