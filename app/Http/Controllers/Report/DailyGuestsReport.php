<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Report\Contracts\Template;
use App\Models\Guest;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use TCPDF_FONTS;

class DailyGuestsReport extends Controller
{
    use Template;
    public function __invoke()
    {
        $guests = Guest::with(['host'])->whereDate('registered_at',now())->get();

        

        $this->header(trans('Daily Guest Report'));
        TCPDF::SetTitle(trans("Daily Guest Report"));
        TCPDF::AddPage();
        $i = 1;
        foreach ($guests as $guest) {
            $this->row(guest: $guest,i: $i);
            $i++;
        }

        return TCPDF::Output(trans("Daily Guest Report") . '.pdf', 'I');

    }

}
