<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Card\CardInfo;
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
        return view('employee.print.card', compact('cardInfo', 'card'));
    }




}
