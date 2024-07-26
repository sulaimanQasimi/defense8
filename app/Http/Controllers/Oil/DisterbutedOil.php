<?php

namespace App\Http\Controllers\Oil;

use App\Http\Controllers\Controller;
use App\Models\Card\CardInfo;
use App\Models\Card\EmployeeVehicalCard;
use App\Models\OilDisterbution;
use Date;
use Elibyy\TCPDF\Facades\TCPDF;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use TCPDF_FONTS;
use Vehical\OilType;
use Vehical\Vehical;

class DisterbutedOil extends Controller
{
    public function __invoke(Request $request)
    {
        $start_date = Verta::parse(Verta::setDateJalali($request->input("startYear"), $request->input("startMonth"), $request->input("startDay")))->toCarbon();
        $end_date = Verta::parse(Verta::setDateJalali($request->input("endYear"), $request->input("endMonth"), $request->input("endDay")))->toCarbon();

        $d_oil = OilDisterbution::query()
            ->whereBetween('filled_date', [$start_date, $end_date])
            ->orderBy("filled_date")

            ->get();

        TCPDF_FONTS::addTTFfont(public_path('mod_font.ttf'), 'TrueTypeUnicode', '', 96);
        TCPDF::SetFont('mod_font', '', 11);
        TCPDF::setRTL(true);
        TCPDF::setPageOrientation('L');
        TCPDF::SetMargins(5, 55, 5);
        TCPDF::SetHeaderMargin(2);
        TCPDF::SetFooterMargin(5);
        TCPDF::SetAutoPageBreak(TRUE, 5);
        TCPDF::setHeaderCallback(function ($pdf) use ($start_date, $end_date) {
            $pdf->SetFont('mod_font', '', 11);
            $pdf->Cell(297, 10, config("app.name"), false, true, 'C');
            $pdf->Cell(297, 10, trans("Oil Disterbution"), false, true, 'C');
            $pdf->Cell(297, 10, verta($start_date)->format("Y/m/d") . '-' . verta($end_date)->format("Y/m/d"), false, true, 'C');
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(107, 0, '');
            $style = [
                'position' => '',
                'align' => 'C',
                'stretch' => false,
                'fitwidth' => true,
                'cellfitalign' => '',
                'border' => true,
                'hpadding' => 'auto',
                'vpadding' => 'auto',
                'fgcolor' => [0, 0, 0],
                'bgcolor' => false,
                //array(255,255,255),
                'text' => true,
                'font' => 'helvetica',
                'fontsize' => 8,
                'stretchtext' => 4,
            ];

            $pdf->write1DBarcode(time(), 'C39', '', '', '', 14, 0.4, $style, 'N');
            $pdf->Image('logo.png', 40, 10, 20, 20);
            // $pdf->Image(, 260, 10, 20, 20);
            $style = [
                'border' => 2,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => [0, 0, 0],
                'bgcolor' => false,
                //array(255,255,255)
                'module_width' => 1,
                // width of a single module in points
                'module_height' => 1,
            ];

            // QRCODE,L : QR-CODE Low error correction
            $pdf->write2DBarcode(now()->toIso8601String(), 'QRCODE,L', 260, 10, 20, 20, $style, 'N');
            $pdf->SetFont('mod_font', '', 12);

            $pdf->SetFillColor(102, 120, 135);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Ln(18);
            $pdf->Cell(9, 7, '#', true, false, 'C', true);
            $pdf->Cell(45, 7, trans('Register No'), true, false, 'C', true);
            $pdf->Cell(45, 7, trans('Name'), true, false, 'C', true);
            $pdf->Cell(45, 7, trans('Father Name'), true, false, 'C', true);
            $pdf->Cell(30, 7, trans("Oil Type"), true, false, 'C', true);
            $pdf->Cell(30, 7, trans("Monthly Rate"), true, false, 'C', true);
            $pdf->Cell(30, 7, trans("Oil Amount"), true, false, 'C', true);
            $pdf->Cell(50, 7, trans("Date"), true, true, 'C', true);
            $pdf->SetTextColor(0, 0, 0);
        });

        TCPDF::AddPage();
        TCPDF::SetFont('mod_font', '', 11);
        $i = 1;
        foreach ($d_oil as $employee) {
            TCPDF::Cell(9, 7, $i++, true, false, 'C', false);
            TCPDF::Cell(45, 7, $employee->card_info->registare_no, true, false, 'C', false);
            TCPDF::Cell(45, 7, $employee->card_info->full_name, true, false, 'C', false);
            TCPDF::Cell(45, 7, $employee->card_info->father_name, true, false, 'C', false);
            TCPDF::Cell(30, 7, trans(($employee->card_info->oil_type == OilType::Diesel) ? "Diesel" : "Petrole"), true, false, 'C', false);
            TCPDF::Cell(30, 7, trans("Liter", ['value' => $employee->card_info->monthly_rate]), true, false, 'C', false);
            TCPDF::Cell(30, 7, trans("Liter", ['value' => $employee->oil_amount]), true, false, 'C', false);
            TCPDF::Cell(50, 7, verta($employee->filled_date)->format('Y/m/d'), true, true, 'C', false);
        }
        return TCPDF::Output("54.pdf", 'i');
    }

}
