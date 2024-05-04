<?php

namespace App\Nova\Actions;

use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Notifications\NovaNotification;
use Laravel\Nova\URL;
use TCPDF_FONTS;

class CurrentMonthAttendanceEmployeeAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $filename=time().'.pdf';


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
        TCPDF::setHeaderCallback(function ($pdf)  use($filename){
            $pdf->SetFont('mod_font', '', 11);
            $pdf->Cell(297, 10, config("app.name"), false, true, 'C');
            $pdf->Cell(297, 10, trans('Monthly Attendance'), false, true, 'C');
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
            $pdf->write2DBarcode(asset("attendance/{$filename}"), 'QRCODE,L', 260, 10, 20, 20, $style, 'N');
            $pdf->SetFont('mod_font', '', 8);

            $pdf->Ln(10);
            $pdf->Cell(9, 7, '#', true, false, 'C');
            $pdf->Cell(30, 7, trans('Name'), true, false, 'C');
            $pdf->Cell(30, 7, trans('Father Name'), true, false, 'C');

            for ($j = 1; $j < 30; $j++) {
                $pdf->Cell(7, 7, $j, true, false, 'C');
            }

            $pdf->Cell(7, 7, 30, true, true, 'C');

        });

        TCPDF::SetTitle('Hello World');
        TCPDF::AddPage();

        $i = 1;
        TCPDF::SetFont('mod_font', '', 8);
        foreach ($models as $employee) {

            TCPDF::SetFont('mod_font', '', 8);
            TCPDF::Cell(9, 7, $i, true, false, 'C');
            TCPDF::Cell(30, 7, $employee->name, true, false, 'C');
            TCPDF::Cell(30, 7, $employee->father_name, true, false, 'C');
            $day = null;
            $employee2 = null;
            $day = array_fill(1, 30, '');

            TCPDF::SetFont('mod_font', '', 16);
            foreach ($employee->gate()->whereMonth('entered_at', '=', date('m'))->whereYear('entered_at', '=', date('Y'))->get() as $employee2) {
                $day[intval(Carbon::make($employee2->pivot->entered_at)->format("d"))] = "*";
            }
            // foreach ($employee->gate as $employee2) {
            //     $day[intval(Carbon::make($employee2->pivot->entered_at)->format("d"))]= "*";
            // }
            for ($j = 1; $j < 30; $j++) {
                TCPDF::Cell(7, 7, $day[$j], true, false, 'C');
            }

            $i++;
            TCPDF::Cell(7, 7, '', true, true, 'C');
        }
        $path=public_path("attendance/{$filename}");

        TCPDF::Output($path, 'F');
        request()->user()->notify(
            NovaNotification::make()->message(trans("You Successfully Download Current Month Attendance"))->type("info")
        );
            request()->user()->notify(
                NovaNotification::make()->message(trans("If File not download automaticaly you can download from here"))
                ->action("Download",URL::remote(asset("attendance/{$filename}")))->icon('download')->type("info"));


        return Action::download(url:asset("attendance/{$filename}"),name:'attendance.pdf') ;

    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
