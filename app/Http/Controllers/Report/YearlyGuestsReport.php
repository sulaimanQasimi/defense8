<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Report\Contracts\Template;
use App\Models\Guest;
use Elibyy\TCPDF\Facades\TCPDF; // Facade for TCPDF library
use Illuminate\Http\Request;

class YearlyGuestsReport extends Controller
{
    use Template; // Incorporating Template contract for report generation
    /**
     * Generate yearly guest report based on registered_at dates
     * between the start and end of the current year.
     *
     *
     */
    public function __invoke(Request $request): void
    {
        $title = trans("Yearly Guest Report");

        $startDate = now()->startOfYear();
        $endDate = now()->endOfYear();

        // Retrieve guests registered between start and end dates
        $guests = Guest::with(['host'])
            ->whereDate('registered_at', '>=', $startDate)
            ->whereDate('registered_at', '<=', $endDate)
            ->get();

        // Add report header with specified title
        $this->header($title);

        // Set the title of the generated PDF
        TCPDF::SetTitle($title);

        // Start a new page for the report
        TCPDF::AddPage();

        $i = 1;

        // Iterate through guests and add a row for each one
        foreach ($guests as $guest) {
            $this->row(guest: $guest, i: $i);
            $i++;
        }

        // Output the PDF to the user
        TCPDF::Output($title . '.pdf', 'I');

    }

}
