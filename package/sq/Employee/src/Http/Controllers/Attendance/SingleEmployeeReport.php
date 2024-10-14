<?php
namespace Sq\Employee\Http\Controllers\Attendance;

use Elibyy\TCPDF\Facades\TCPDF;
use Hekmatinasser\Verta\Facades\Verta;
use Sq\Employee\Models\Department;
use TCPDF_FONTS;

class SingleEmployeeReport
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


    public function __construct(
        private $employee,
        private $date,
        private $start,
        private $end,
        private $year,
        private $month,

    ) {
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
        TCPDF::AddPage();
        TCPDF_FONTS::addTTFfont(public_path('mod_font.ttf'), 'TrueTypeUnicode', '', 96);
        TCPDF::SetFont('mod_font', '', 11);
        TCPDF::setRTL(true);
        // TCPDF::setPageOrientation(orientation: 'L');
        TCPDF::SetMargins(left: 5, top: 0, right: 5);
        TCPDF::SetHeaderMargin(0);
        // TCPDF::SetFooterMargin(5);
        TCPDF::SetAutoPageBreak(auto: TRUE, margin: 5);
        TCPDF::SetFont('mod_font', '', 11);
        TCPDF::Cell(197, 5, config("app.name"), false, true, 'C');
        TCPDF::Cell(197, 5, $this->employee?->orginization?->fa_name, false, true, 'C');
        TCPDF::Cell(197, 5, $this->header_title ?? trans('Monthly CURRENT MONTH ATTENDANCE EMPLOYEE', ['month' => $this->month()]), false, true, 'C');
        TCPDF::Cell(197, 5, $this->formatDate(), false, true, 'C');
        TCPDF::SetFont('helvetica', '', 10);
        TCPDF::Cell(60, 0, '');
        $style = [
            'position' => 'absolute',
            'align' => 'C',
            'stretch' => true,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => [255, 0, 0],
            'bgcolor' => false,
            //array(255,255,255),
            'text' => false,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4,
        ];

        TCPDF::write1DBarcode(time(), 'C39', '', '', '', 14, 0.4, $style, 'N');
        TCPDF::Image('logo.png', 40, 10, 20, 20);
        // TCPDF::Image(, 260, 10, 20, 20);
        $style = [
            'border' => 2,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => [255, 0, 0],
            'bgcolor' => false,
            //array(255,255,255)
            'module_width' => 1,
            // width of a single module in points
            'module_height' => 1,
        ];

        // QRCODE,L : QR-CODE Low error correction
        TCPDF::write2DBarcode(now()->toIso8601String(), 'QRCODE,L', 190, 10, 20, 20, $style, 'N');
        TCPDF::SetFont('mod_font', '', 8);


        TCPDF::Ln(18);
        TCPDF::Cell(40, 7, trans('Name'), true, false, 'C', false);
        TCPDF::Cell(30, 7, $this->employee->name, true, false, 'C', false);
        TCPDF::Cell(30, 7, trans('Father Name'), true, false, 'C', false);
        TCPDF::Cell(30, 7, $this->employee->name, true, false, 'C', false);
        TCPDF::Cell(30, 7, trans('Register No'), true, false, 'C', false);
        TCPDF::Cell(30, 7, $this->employee->registare_no, true, true, 'C', false);

        $day = array_fill(1, 31, null);
        foreach ($this->employee->attendance as $attendance) {
            $day[intval(value: $attendance->shamsi_day)] = $attendance;
        }

        for ($j = 1; $j <= 31; $j++) {

            TCPDF::SetFillColor(255, 255, 255);
            // TCPDF::SetTextColor(255, 255, 255);

            if (Verta::setDateJalali($this->year, $this->month, $j)->isFriday()) {
                TCPDF::SetFillColor(116, 49, 49);
                // TCPDF::SetTextColor(255, 255, 255);
            }

            TCPDF::Cell(10, 7, $j, true, false, 'C', false);
            if (is_null($day[$j])) {
                TCPDF::Cell(30, 7, '', true, false, 'C', false);
                TCPDF::Cell(30, 7, '', true, false, 'C', false);
                TCPDF::Cell(10, 7, '', true, false, 'C', true);
                TCPDF::Cell(30, 7, Verta::setDateJalali($this->year, $this->month, $j)->format("Y/m/d"), false, true, 'C', false);

            } else {

                if ($day[$j]->label == "ح") {
                    TCPDF::SetFillColor(0, 255, 0);
                    TCPDF::SetTextColor(0, 0, 0);
                }

                if ($day[$j]->label == "غ") {
                    TCPDF::SetFillColor(255, 0, 0);
                    TCPDF::SetTextColor(0, 0, 0);
                }
                TCPDF::Cell(30, 7, ($day[$j]->enter) ? verta($day[$j]->enter) : '', true, false, 'C', false);
                TCPDF::Cell(30, 7, ($day[$j]->exit) ? verta($day[$j]->exit) : '', true, false, 'C', false);
                TCPDF::Cell(10, 7, $day[$j]->label, true, false, 'C', true);
                TCPDF::Cell(30, 7, Verta::setDateJalali($this->year, $this->month, $j)->format("Y/m/d"), false, true, 'C');

            }
        }

        $days = collect($this->employee->attendance);


        TCPDF::Cell(40, 7, trans("Present"), true, false, 'C', false);
        TCPDF::Cell(40, 7, $days->where('state', 'P')->count(), true, true, 'C');

        TCPDF::Cell(40, 7, trans("Upsent"), true, false, 'C', false);
        TCPDF::Cell(40, 7, $days->where('state', 'U')->count(), true, true, 'C');

        return $this;
    }
    public function download()
    {
        return TCPDF::Output(name: $this->month() . ".pdf", dest: 'i');
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
