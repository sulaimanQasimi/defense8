<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Report\Contracts\Template;
use App\Models\Guest;
use Elibyy\TCPDF\Facades\TCPDF;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use TCPDF_FONTS;

class CustomGuestsReport extends Controller
{
    use Template;
    public function __invoke(Request $request)
    {

        $start_date =Verta::parse(Verta::setDateJalali($request->input("startYear"), $request->input("startMonth"), $request->input("startDay")))->toCarbon() ;
        $end_date = Verta::parse(Verta::setDateJalali($request->input("endYear"), $request->input("endMonth"), $request->input("endDay")))->toCarbon();
        
        $guests = Guest::with(['host'])->whereBetween('registered_at', [$start_date, $end_date])->get();

        $this->header(trans('Daily Guest Report'));
        TCPDF::SetTitle(trans("Daily Guest Report"));
        TCPDF::AddPage();
        $i = 1;
        foreach ($guests as $guest) {
            $this->row(guest: $guest, i: $i);
            $i++;
        }

        return TCPDF::Output(trans("Daily Guest Report") . '.pdf', 'I');

    }

}
