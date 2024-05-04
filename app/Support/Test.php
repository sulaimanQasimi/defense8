<?php
namespace App\Support;

use App\Models\Guest;
use \Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\Hash;
use TCPDF_FONTS;
class Test
{
    public $model = Guest::class;

    public function __construct()
    {
       TCPDF_FONTS::addTTFfont(public_path('mod_font.ttf'), 'TrueTypeUnicode', '', 96);

TCPDF::SetProtection( user_pass :'', owner_pass: 'S11solai', mode : 0,permissions:[]);
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
       // $pdf->Image(, 260, 10, 20, 20);
       TCPDF::AddPage();

       TCPDF::Image('logo.png', 110, 10, 60, 60);
TCPDF::Output("h.pdf","I");

    }
}
