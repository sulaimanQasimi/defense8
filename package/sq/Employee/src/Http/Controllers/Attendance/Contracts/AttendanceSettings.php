<?php
namespace Sq\Employee\Http\Controllers\Attendance\Contracts;
use Elibyy\TCPDF\Facades\TCPDF;
use Hekmatinasser\Verta\Facades\Verta;
use TCPDF_FONTS;
abstract class AttendanceSettings
{
    protected $cell = [
        "P" => 197,
        "L" => 297
    ];
    protected $landscape = 297;
    protected $orientation = "P";
    protected $department;
    protected $date;
    protected $start;
    protected $end;
    protected $year;
    protected $month;
    protected $barcode;

    protected $months = [
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

        protected readonly bool $downloadable = false,
    ) {
        $this->barcode = time();
        $this->year = request()->input('year') ?? verta()->year;
        $this->month = request()->input('month') ?? verta()->month;
        $this->setDate($this->year, $this->month);


        TCPDF_FONTS::addTTFfont(public_path('mod_font.ttf'), 'TrueTypeUnicode', '', 96);
        TCPDF::SetFont('mod_font', '', 11);
        TCPDF::setRTL(true);
        TCPDF::setPageOrientation(orientation: $this->orientation);
        TCPDF::SetMargins(left: 5, top: 5, right: 5);
        TCPDF::SetHeaderMargin(0);
        TCPDF::SetFooterMargin(10);
        // TCPDF::SetFooterMargin(5);
        TCPDF::SetAutoPageBreak(auto: TRUE, margin: 5);
        TCPDF::SetFont('mod_font', '', 8);
        TCPDF::setFooterCallback(function ($pdf) {
            $pdf->Cell(0, 10, $pdf->getAliasNumPage() . '/' . $pdf->getAliasNbPages() . " {$this->barcode}", 0, false, 'L', 0, '', 0);

        });

    }
    private function setDate($year, $month): void
    {
        $date = $this->date = Verta::setDateJalali($year, $month, 25);
        $this->start = Verta::parse($date->startMonth()->format("Y-m-d"))->toCarbon();
        $this->end = Verta::parse($date->endMonth()->format("Y-m-d"))->toCarbon();
    }

    public function download()
    {
        return TCPDF::Output(name: $this->month() . ".pdf", dest: ($this->downloadable) ? 'D' : 'i');
    }

    protected function formatDate()
    {
        return verta(datetime: $this->date)->format(format: "Y-m");
    }
    protected function month(): string
    {
        return trans(key: $this->months[intval(verta($this->date)->month)]);
    }
    protected function header()
    {

        TCPDF::Cell($this->cell[$this->orientation], 5, config("app.name"), false, true, 'C');
        TCPDF::Cell($this->cell[$this->orientation], 5, $this->department?->fa_name, false, true, 'C');
        TCPDF::Cell($this->cell[$this->orientation], 5, $this->header_title ?? trans('Monthly CURRENT MONTH ATTENDANCE EMPLOYEE', ['month' => $this->month()]), false, true, 'C');
        TCPDF::Cell($this->cell[$this->orientation], 5, $this->formatDate(), false, true, 'C');
        TCPDF::SetFont('helvetica', '', 10);
        TCPDF::Cell(($this->orientation == 'P') ? 60 : 110, 0, '');
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
            'fontsize' => 5,
            'stretchtext' => 4,
        ];

        TCPDF::write1DBarcode($this->barcode, 'C39', '', '', '', 14, 0.4, $style, 'N');
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
        TCPDF::write2DBarcode(now()->toIso8601String(), 'QRCODE,L', ($this->orientation == 'P') ? 190 : 290, 10, 20, 20, $style, 'N');
        TCPDF::SetFont('mod_font', '', 8);


    }
}
