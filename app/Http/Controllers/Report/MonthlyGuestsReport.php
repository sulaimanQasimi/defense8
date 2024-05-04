<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Report\Contracts\Template;
use App\Models\Guest;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use TCPDF_FONTS;

class MonthlyGuestsReport extends Controller
{
    use Template;
    public function __invoke()
    {
        $title=trans("Monthly Guest Report");
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        $guests = Guest::with(['host'])
            ->whereDate('registered_at', '>=', $startDate)
            ->whereDate('registered_at', '<=', $endDate)
            ->get();

        $this->header($title);
        TCPDF::SetTitle($title);
        TCPDF::AddPage();
        $i = 1;
        foreach ($guests as $guest) {
            $this->row(guest: $guest, i: $i);
            $i++;
        }

        return TCPDF::Output( $title. '.pdf', 'I');

    }

}
