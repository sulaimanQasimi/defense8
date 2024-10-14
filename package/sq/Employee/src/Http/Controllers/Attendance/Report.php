<?php
namespace Sq\Employee\Http\Controllers\Attendance;

use Elibyy\TCPDF\Facades\TCPDF;
use Hekmatinasser\Verta\Facades\Verta;
use Sq\Employee\Models\Department;
use TCPDF_FONTS;

class Report
{
    private $months = [
        "",
        "Hamal",
        "Thour",
        "Jawza",
        "Sarathan",
        "Asad",
        "Sunbulah",
        "Mizan",
        "Aqrab",
        "Qous",
        "Jadi",
        "Dalwa",
        "Hod",
    ];

    private $employees;

    public function __construct(
        callable $employee,
        private $date,
        private $start,
        private $end,
        private $year,
        private $month,
        private readonly Department $department,
        private readonly bool $downloadable = false,
        private readonly string|null $header_title = null,
        private readonly int $nameColumnSize = 30,
        private readonly int $fatherNameColumnSize = 30

    ) {
        $this->employees = $employee()
        ->with([
            'attendance' => function ($query) {
                $query
                    ->orderBy('date', 'ASC')
                    ->whereBetween("date", [$this->start, $this->end]);
            }
        ])->get();
    }
    public function add_more_report($date, $start, $end)
    {
        $this->date = $date;
        $this->start = $start;
        $this->end = $end;
        return $this->maker();
    }
    public function maker()
    {
        $this->header();

        TCPDF::AddPage();
        $i = 1;
        TCPDF::SetFont('mod_font', '', 8);
        foreach ($this->employees as $employee) {
            TCPDF::Cell(9, 7, $i, true, false, 'C');
            TCPDF::Cell($this->nameColumnSize, 7, $employee->name, true, false, 'C');
            TCPDF::Cell($this->fatherNameColumnSize, 7, $employee->father_name, true, false, 'C');

            $day = array_fill(1, 31, '');
            foreach ($employee->attendance as $attendance) {
                $day[intval($attendance->shamsi_day)] = $attendance->label;
            }
            TCPDF::SetFillColor(255, 255, 255);
            TCPDF::SetTextColor(0, 0, 0);
            for ($j = 1; $j <= 31; $j++) {
                if ($day[$j] == "ح") {
                    TCPDF::SetFillColor(0, 255, 0);
                    TCPDF::SetTextColor(0, 0, 0);
                }
                if ($day[$j] == "غ") {
                    TCPDF::SetFillColor( 255,0, 0);
                    TCPDF::SetTextColor(0, 0, 0);
                }


                if (Verta::setDateJalali($this->year, $this->month, $j)->isFriday()) {
                    TCPDF::SetFillColor(116, 49, 49);
                    TCPDF::SetTextColor(255, 255, 255);
                }

                TCPDF::Cell(6, 7, $day[$j], true, false, 'C', true);

                TCPDF::SetFillColor(255, 255, 255);
                TCPDF::SetTextColor(0, 0, 0);
            }

            $days = collect($employee->attendance);

            TCPDF::Cell(10, 7, $days->where('state', 'P')->count(), true, false, 'C');

            TCPDF::Cell(10, 7, $days->where('state', 'U')->count(), true, false, 'C');
            TCPDF::Cell(10, 7, $days->whereNotNull('state')->count(), true, true, 'C');

            $i++;
        }
        return $this;
    }
    private function header(): void
    {

        TCPDF_FONTS::addTTFfont(public_path('mod_font.ttf'), 'TrueTypeUnicode', '', 96);
        TCPDF::SetFont('mod_font', '', 11);
        TCPDF::setRTL(true);
        TCPDF::setPageOrientation(orientation: 'L');
        TCPDF::SetMargins(left: 5, top: 55, right: 5);
        TCPDF::SetHeaderMargin(2);
        TCPDF::SetFooterMargin(5);
        TCPDF::SetAutoPageBreak(auto: TRUE, margin: 5);
        TCPDF::setHeaderCallback(headerCallback: function ($pdf) {
            $pdf->SetFont('mod_font', '', 11);
            $pdf->Cell(297, 5, config("app.name"), false, true, 'C');
            $pdf->Cell(297, 5, $this->department->fa_name, false, true, 'C');
            $pdf->Cell(297, 5, $this->header_title ?? trans('Monthly CURRENT MONTH ATTENDANCE EMPLOYEE', ['month' => $this->month()]), false, true, 'C');
            $pdf->Cell(297, 5, $this->formatDate(), false, true, 'C');
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
            $pdf->SetFont('mod_font', '', 8);

            $pdf->SetFillColor(102, 120, 135);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Ln(18);
            $pdf->Cell(9, 7, '#', true, false, 'C', true);
            $pdf->Cell($this->nameColumnSize, 7, trans('Name'), true, false, 'C', true);
            $pdf->Cell($this->fatherNameColumnSize, 7, trans('Father Name'), true, false, 'C', true);
            for ($j = 1; $j <= 31; $j++) {
                if (Verta::setDateJalali($this->year, $this->month, $j)->isFriday()) {
                    $pdf->SetFillColor(116, 49, 49);
                    $pdf->SetTextColor(255, 255, 255);
                }
                $pdf->Cell(6, 7, $j, true, false, 'C', true);

                $pdf->SetFillColor(102, 120, 135);
                $pdf->SetTextColor(255, 255, 255);
            }
            $pdf->Cell(10, 7, trans("Present"), true, false, 'C', true);

            $pdf->Cell(10, 7, trans("Upsent"), true, false, 'C', true);
            $pdf->Cell(10, 7, trans("Total"), true, true, 'C', true);
            $pdf->SetTextColor(0, 0, 0);
        });
    }
    public function download()
    {

        return TCPDF::Output(name: $this->month() . ".pdf", dest: ($this->downloadable) ? 'D' : 'i');

    }
    private function formatDate()
    {
        return verta(datetime: $this->date)->format(format: "Y-m");
    }
    private function month(): string
    {
        return trans(key: $this->months[intval(verta($this->date)->month)]);
    }
}
