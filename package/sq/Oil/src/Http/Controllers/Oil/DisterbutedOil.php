<?php

namespace Sq\Oil\Http\Controllers\Oil;

use Sq\Oil\Exports\DisterbutedOilExcelExport;
use Sq\Oil\Models\OilDisterbution;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use Sq\Query\DateFromAndToModelQuery;
use TCPDF_FONTS;
use Vehical\OilType;

class DisterbutedOil
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

        $createQuery = new DateFromAndToModelQuery(OilDisterbution::class, 'filled_date');
        $department = request()->input('department', null);
        $d_oil = $createQuery->query()
            ->when(
                $department,
                function ($query) use ($department) {
                    return $query->whereHas('card_info', function ($query) use ($department) {
                        return $query->where("department_id", $department);
                    });
                }
            )
            ->when(request()->input('employee'), function ($query) use ($department) {
                return $query->where('card_info_id', request()->input('employee'));
            })

            ->get();

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
            $pdf->Cell(297, 10, trans("Oil Disterbution"), false, true, 'C');
            $end = $createQuery->end ? '-' . verta($createQuery->end)->format("Y/m/d") : '';
            $pdf->Cell(297, 10, verta($createQuery->start)->format("Y/m/d") . $end, false, true, 'C');
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
            $pdf->Cell(40, 7, trans('Department'), true, false, 'C', true);
            $pdf->Cell(40, 7, trans('Register No'), true, false, 'C', true);
            $pdf->Cell(40, 7, trans('Name'), true, false, 'C', true);
            $pdf->Cell(40, 7, trans('Father Name'), true, false, 'C', true);
            $pdf->Cell(25, 7, trans("Oil Type"), true, false, 'C', true);
            $pdf->Cell(25, 7, trans("Monthly Rate"), true, false, 'C', true);
            $pdf->Cell(25, 7, trans("Oil Amount"), true, false, 'C', true);
            $pdf->Cell(25, 7, trans("Date"), true, true, 'C', true);
            $pdf->SetTextColor(0, 0, 0);
        });

        TCPDF::AddPage();
        TCPDF::SetFont('mod_font', '', 10);
        $i = 1;
        foreach ($d_oil as $employee) {
            TCPDF::Cell(9, 7, $i++, true, false, 'C', false);
            TCPDF::Cell(40, 7, $employee->card_info->orginization?->fa_name, true, false, 'C', false);
            TCPDF::Cell(40, 7, $employee->card_info->registare_no, true, false, 'C', false);
            TCPDF::Cell(40, 7, $employee->card_info->full_name, true, false, 'C', false);
            TCPDF::Cell(40, 7, $employee->card_info->father_name, true, false, 'C', false);
            TCPDF::Cell(25, 7, trans(($employee->card_info->oil_type == OilType::Diesel) ? "Diesel" : "Petrole"), true, false, 'C', false);
            TCPDF::Cell(25, 7, trans("Liter", ['value' => $employee->card_info->monthly_rate]), true, false, 'C', false);
            TCPDF::Cell(25, 7, trans("Liter", ['value' => $employee->oil_amount]), true, false, 'C', false);
            TCPDF::Cell(25, 7, verta($employee->filled_date)->format('Y/m/d'), true, true, 'C', false);
        }
        return TCPDF::Output("54.pdf", 'i');
    }
    public function excel()
    {
        return (new DisterbutedOilExcelExport)->download('oil_disterbution.xlsx');
    }
}
