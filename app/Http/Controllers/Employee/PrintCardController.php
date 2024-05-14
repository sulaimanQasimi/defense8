<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Card\CardInfo;
use App\Models\Card\GunCard;
use App\Models\PrintCardFrame;
use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\View;

class PrintCardController extends Controller
{
    public function employee(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::Employee) {
            return abort(404);
        }
        return $this->view_layout($cardInfo, $card, ($card->dim === "vertical") ? true : false);
    }
    public function gun(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::Gun) {
            return abort(404);
        }
        return $this->view_layout($cardInfo, $card, ($card->dim === "vertical") ? true : false);
    }

    public function employee_car(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::EmployeeCar) {
            return abort(404);
        }
        return $this->view_layout($cardInfo, $card, ($card->dim === "vertical") ? true : false);
    }


    public function black_mirror_car(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::BlackMirrorCar) {
            return abort(404);
        }
        return $this->view_layout($cardInfo, $card, ($card->dim === "vertical") ? true : false);
    }


    public function armor_car(Request $request, CardInfo $cardInfo, int $printCardFrame): View
    {
        $card = PrintCardFrame::findOrFail($printCardFrame);
        if (!$card->type == PrintTypeEnum::ArmorCar) {
            return abort(404);
        }
        return $this->view_layout($cardInfo, $card, ($card->dim === "vertical") ? true : false);

    }
    public function view_layout($cardInfo, $card, bool $vertical)
    {
        if($vertical){
            return view('employee.print.card-vertical', compact('cardInfo', 'card'));
        }
        return view('employee.print.card-horizontal', compact('cardInfo', 'card'));
    }
}
