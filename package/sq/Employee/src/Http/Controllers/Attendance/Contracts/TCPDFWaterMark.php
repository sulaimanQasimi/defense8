<?php
namespace Sq\Employee\Http\Controllers\Attendance\Contracts;
use Elibyy\TCPDF\TCPDF;
class TCPDFWaterMark extends TCPDF
{
    public function Header()
    {
        $this->setFont('', "B", 40);
    }

}
