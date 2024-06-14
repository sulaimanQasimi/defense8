<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Card\CardInfo;
use App\Models\Card\GunCard;
use App\Models\PrintCardFrame;
use App\Support\Defense\Print\PrintTypeEnum;
use Card\PrintCardField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PrintCardController extends Controller
{
    public function employee(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::Employee) {
            return abort(404);
        }
        return $this->layout($cardInfo, $card, ($card->dim === "vertical") ? true : false);
    }
    public function gun(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::Gun) {
            return abort(404);
        }
        return $this->layout($cardInfo, $card, ($card->dim === "vertical") ? true : false);
    }

    public function employee_car(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::EmployeeCar) {
            return abort(404);
        }
        return $this->layout($cardInfo, $card, ($card->dim === "vertical") ? true : false);
    }


    public function black_mirror_car(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::BlackMirrorCar) {
            return abort(404);
        }
        return $this->layout($cardInfo, $card, ($card->dim === "vertical") ? true : false);
    }


    public function armor_car(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::ArmorCar) {
            return abort(404);
        }
        return $this->layout($cardInfo, $card, ($card->dim === "vertical") ? true : false);

    }
    public function layout($cardInfo, $card, bool $vertical)
    {
        app()->setLocale('fa');
        $field = new PrintCardField($cardInfo, $card);
        $details = $field->details;
        $remark = $field->remark;
        Cookie::make('your_id', time(), 1);
        if ($vertical) {
            return view('employee.print.card-vertical', compact('cardInfo', 'card'));
        }

        return view('employee.print.card-horizontal', compact('cardInfo', 'card', 'details', 'remark'));
    }
}
