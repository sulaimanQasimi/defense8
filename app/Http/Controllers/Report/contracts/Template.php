<?php
namespace App\Http\Controllers\Report\Contracts;

use App\Models\Guest;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\Hash;
use TCPDF_FONTS;

trait Template
{
    public function header(string $title): void
    {

        TCPDF_FONTS::addTTFfont(public_path('mod_font.ttf'), 'TrueTypeUnicode', '', 96);

        TCPDF::SetFont('mod_font', '', 11);
        TCPDF::setRTL(true);
        TCPDF::setPageOrientation('L');
        // set default header data

        // set header and footer fonts
        TCPDF::SetMargins(5, 47, 5);
        TCPDF::SetHeaderMargin(5);
        TCPDF::SetFooterMargin(5);

        // set auto page breaks
        TCPDF::SetAutoPageBreak(TRUE, 5);

        // set image scale factor

        // Arabic and English content
        TCPDF::setHeaderCallback(function ($pdf) use ($title) {
            $pdf->SetFont('mod_font', '', 11);
            $pdf->Cell(297, 10, config("app.name"), false, true, 'C');
            $pdf->Cell(297, 10, $title, false, true, 'C');
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
            $pdf->write2DBarcode("
            User:".request()->user()->email."
            Time:".verta(now())."
            Code:".Hash::make(request()->user()->email)."


            ", 'QRCODE,L', 260, 10, 20, 20, $style, 'N');
            $pdf->SetFont('mod_font', '', 8);

            $pdf->Ln(10);
            $pdf->Cell(9, 7, '#', true, false, 'C');
            $pdf->Cell(25, 7, trans('Name'), true, false, 'C');
            $pdf->Cell(25, 7, trans('Last Name'), true, false, 'C');
            $pdf->Cell(20, 7, trans('Career'), true, false, 'C');
            $pdf->Cell(30, 7, trans('Invited By'), true, false, 'C');
            $pdf->Cell(30, 7, trans('Address'), true, false, 'C');
            $pdf->Cell(30, 7, trans('Guest Enter Date'), true, false, 'C');
            $pdf->Cell(30, 7, trans('Enter Gate'), true, false, 'C');
            $pdf->Cell(30, 7, trans('Exit At'), true, false, 'C');
            $pdf->Cell(60, 7, trans('Condition'), true, true, 'C');

        });


        TCPDF::SetFont('mod_font', '', 7);
    }
    public function row($guest, $i): void
    {
        TCPDF::Cell(9, 7, $i, true, false, 'C');
        TCPDF::Cell(25, 7, $guest->name, true, false, 'C');
        TCPDF::Cell(25, 7, $guest->last_name, true, false, 'C');
        TCPDF::Cell(20, 7, $guest->career, true, false, 'C');
        TCPDF::Cell(30, 7, $guest->host->department->fa_name, true, false, 'C');
        TCPDF::Cell(30, 7, $guest->address, true, false, 'C');
        TCPDF::Cell(30, 7, verta($guest->registered_at), true, false, 'C');
        TCPDF::Cell(30, 7, $guest->enter_gate, true, false, 'C');
        TCPDF::Cell(30, 7, $guest->ExitGate?->exit_at, true, false, 'C');
        TCPDF::Cell(60, 7, $this->condition_wrap($guest->Guestoptions), true, true, 'C');

    }

    public function condition_wrap($condition)
    {
        $text = "";
        foreach ($condition as $value) {
            $text .= "-" . $value->name;
        }
        return $text;
    }
}
