<?php
namespace Sq\Employee\Http\Controllers\Attendance;

use Elibyy\TCPDF\Facades\TCPDF;
use Hekmatinasser\Verta\Facades\Verta;
use Sq\Employee\Http\Controllers\Attendance\Contracts\AttendanceSettings;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\Department;
use Sq\Query\Policy\UserDepartment;
use TCPDF_FONTS;

class Report extends AttendanceSettings
{
    private $employees;
    protected $department;
    protected $orientation="L";
    protected int $nameColumnSize = 30;
    protected int $fatherNameColumnSize = 30;

    public function __construct(
        private $department_id,

    ) {
        if (!in_array($department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }
        parent::__construct();
        //
        $this->department = Department::find($department_id);


        $this->employees = CardInfo::where('department_id', $department_id)->orderBy('name')
            ->with([
                'attendance' => function ($query) {
                    $query
                        ->orderBy('date', 'ASC')
                        ->whereBetween("date", [$this->start, $this->end]);
                }
            ])->get();
    }
    public function maker()
    {


        TCPDF::AddPage();
        $this->header();
        TCPDF::SetFillColor(102, 120, 135);
        TCPDF::SetTextColor(255, 255, 255);
        TCPDF::Ln(10);
        TCPDF::Cell(9, 7, '#', true, false, 'C', true);
        TCPDF::Cell($this->nameColumnSize, 7, trans('Name'), true, false, 'C', true);
        TCPDF::Cell($this->fatherNameColumnSize, 7, trans('Father Name'), true, false, 'C', true);
        for ($j = 1; $j <= 31; $j++) {
            if (Verta::setDateJalali($this->year, $this->month, $j)->isFriday()) {
                TCPDF::SetFillColor(116, 49, 49);
                TCPDF::SetTextColor(255, 255, 255);
            }
            TCPDF::Cell(6, 7, $j, true, false, 'C', true);

            TCPDF::SetFillColor(102, 120, 135);
            TCPDF::SetTextColor(255, 255, 255);
        }
        TCPDF::Cell(10, 7, trans("Present"), true, false, 'C', true);

        TCPDF::Cell(10, 7, trans("Upsent"), true, false, 'C', true);
        TCPDF::Cell(10, 7, trans("Total"), true, true, 'C', true);

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
                    TCPDF::SetFillColor(255, 0, 0);
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
}
