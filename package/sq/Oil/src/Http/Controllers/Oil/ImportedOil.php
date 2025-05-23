<?php

namespace Sq\Oil\Http\Controllers\Oil;

use Sq\Oil\Exports\ImportedOilExcelExport;
use Sq\Oil\Models\Oil;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use Sq\Query\DateFromAndToModelQuery;
use TCPDF_FONTS;
use Vehical\OilType;

class ImportedOil
{
    public function __invoke(Request $request)
    {
        if ($request->input('file') == 'excel') {
            return $this->excel();
        }
        return $this->pdf();
    }
    public function pdf()
    {
        $createQuery = new DateFromAndToModelQuery(Oil::class, 'filled_date');

        $oil = $createQuery->query()->get();

        TCPDF_FONTS::addTTFfont(public_path('mod_font.ttf'), 'TrueTypeUnicode', '', 96);
        TCPDF::SetFont('mod_font', '', 11);
        TCPDF::setRTL(true);
        TCPDF::setPageOrientation('L');
        TCPDF::SetMargins(5, 55, 5);
        TCPDF::SetHeaderMargin(2);
        TCPDF::SetFooterMargin(5);
        TCPDF::SetAutoPageBreak(TRUE, 5);
        TCPDF::setHeaderCallback(function ($pdf) use ($createQuery) {
            $pdf->SetFont('mod_font', '', 11);
            $pdf->Cell(297, 10, config("app.name"), false, true, 'C');
            $pdf->Cell(297, 10, trans("Disterbuted Oil"), false, true, 'C');
            $pdf->Cell(297, 10, verta($createQuery->start)->format("Y/m/d") . '-' . verta($createQuery->end)->format("Y/m/d"), false, true, 'C');
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
            $pdf->Cell(55, 7, trans('Code'), true, false, 'C', true);
            $pdf->Cell(55, 7, trans("Oil Type"), true, false, 'C', true);
            $pdf->Cell(55, 7, trans('Oil Quality'), true, false, 'C', true);
            $pdf->Cell(55, 7, trans("Oil Amount"), true, false, 'C', true);
            $pdf->Cell(55, 7, trans("Date"), true, true, 'C', true);
            $pdf->SetTextColor(0, 0, 0);
        });

        TCPDF::AddPage();
        TCPDF::SetFont('mod_font', '', 11);
        $i = 1;
        foreach ($oil as $employee) {
            TCPDF::Cell(9, 7, $i++, true, false, 'C', false);
            TCPDF::Cell(55, 7, $employee->code, true, false, 'C', false);
            TCPDF::Cell(55, 7, trans(($employee->oil_type == OilType::Diesel) ? "Diesel" : "Petrole"), true, false, 'C', false);

            TCPDF::Cell(55, 7, $employee->oil_quality->name, true, false, 'C', false);
            TCPDF::Cell(55, 7, trans("Liter", ['value' => $employee->oil_amount]), true, false, 'C', false);
            TCPDF::Cell(55, 7, verta($employee->filled_date)->format('Y/m/d'), true, true, 'C', false);
        }
        return TCPDF::Output("54.pdf", 'i');
    }
    public function excel()
    {
        return (new ImportedOilExcelExport)->download('imported_oil.xlsx');
    }

}
