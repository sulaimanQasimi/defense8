<?php
namespace Sq\Employee\Document;

use Elibyy\TCPDF\Facades\TCPDF;
use Sq\Query\Support\BloodEnum;
use TCPDF_FONTS;

class PersonalInfo
{
    public function __construct()
    {
        TCPDF_FONTS::addTTFfont(public_path('mod_font.ttf'), 'TrueTypeUnicode', '', 96);
        TCPDF::SetFont('mod_font', '', 11);
        TCPDF::setRTL(true);
        TCPDF::SetHeaderMargin(2);
        TCPDF::SetFooterMargin(5);
        TCPDF::SetAutoPageBreak(TRUE, 5);

    }

    final private function header($employee)
    {
        TCPDF::AddPage();
        TCPDF::SetFont('mod_font', '', 11);
        TCPDF::Image('logo.png', 112, 10, 20, 20);
        TCPDF::Ln(22);
        TCPDF::Cell(197, 5,  config("app.name"), false, true, 'C');
        TCPDF::Cell(197, 5, optional($employee->orginization)->fa_name, false, true, 'C');
        TCPDF::Cell(197, 5, trans('Employee Personal Info'), false, true, 'C');
        return $this;
    }
    public function maker($employee)
    {
        $this->header($employee);

        TCPDF::Ln(5);
        TCPDF::SetFont('mod_font', '', 8);

        TCPDF::Cell(130, 7, trans("Info"), true, true, 'C');

        // Row 1
        TCPDF::Cell(30, 7, trans("Name"), true, false, 'C', false);

        TCPDF::SetTextColor(0, 0, 0);
        TCPDF::Cell(35, 7, $employee->name, true, false, 'C');
        TCPDF::Cell(30, 7, trans("Last Name"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->last_name, true, true, 'C');

        TCPDF::Cell(30, 7, trans("Father Name"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->father_name, true, false, 'C');
        TCPDF::Cell(30, 7, trans("Grand Father Name"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->grand_name, true, true, 'C');


        // Row 2
        TCPDF::Cell(30, 7, trans("Date of Birth"), true, false, 'C');
        TCPDF::Cell(35, 7, verta($employee->birthday)->format("Y/m/d"), true, false, 'C');
        TCPDF::Cell(30, 7, trans("National ID"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->national_id, true, true, 'C');

        TCPDF::Cell(30, 7, trans("Phone"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->phone, true, false, 'C');
        TCPDF::Cell(30, 7, trans("Blood Group"), true, false, 'C');
        TCPDF::Cell(35, 7, match($employee->blood_group){
            'OM' => 'O-',
            'OP' => 'O+',
            'AM' => 'A-',
            'AP' => 'A+',
            'BM' => 'B-',
            'BP' => 'B+',
            'ABM' => 'AB-',
            'ABP' => 'AB+',
            default =>''

        }, true, true, 'C');


        TCPDF::Image($employee->photo?storage_path("app/public/$employee->photo"):storage_path('app/logo.png'), 50, 50, 40, 40);

        TCPDF::Ln(10);
        TCPDF::Cell(195, 7, trans("Job"), true, true, 'C');

        // Row 3
        TCPDF::Cell(30, 7, trans("Degree"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->degree, true, false, 'C');

        TCPDF::Cell(30, 7, trans("Grade"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->grade, true, false, 'C');

        TCPDF::Cell(30, 7, trans("Job Stracture Title"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->job_structure, true, true, 'C');

        TCPDF::Cell(30, 7, trans("Acupation"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->acupation, true, false, 'C');

        TCPDF::Cell(30, 7, trans("Department/Chancellor"), true, false, 'C');
        TCPDF::Cell(35, 7, optional($employee->orginization)->fa_name, true, false, 'C');

        TCPDF::Cell(30, 7, trans("Previous Job"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->previous_job, true, true, 'C');

        TCPDF::Ln(10);
        TCPDF::Cell(195, 7, trans("Main Address"), true, true, 'C');

        // Row 3
        TCPDF::Cell(30, 7, trans("Main Provice"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->m_province, true, false, 'C');

        TCPDF::Cell(30, 7, trans("Main District"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->m_district, true, false, 'C');

        TCPDF::Cell(30, 7, trans("Main Village"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->m_village, true,  true, 'C');

        TCPDF::Ln(5);
        TCPDF::Cell(195, 7, trans("Current Address"), true, true, 'C');

        TCPDF::Cell(30, 7, trans("Current Provice"), true, false, 'C');

        TCPDF::Cell(35, 7, $employee->c_province, true, false, 'C');

        TCPDF::Cell(30, 7, trans("Current District"), true, false, 'C');

        TCPDF::Cell(35, 7, $employee->c_district, true, false, 'C');

        TCPDF::Cell(30, 7, trans("Current Village"), true, false, 'C');
        TCPDF::Cell(35, 7, $employee->c_village, true, true, 'C');


        return $this;

    }

    public function download()
    {
        return TCPDF::Output("Personal Info.pdf", 'i');
    }
}
