<?php
namespace Sq\Employee\Http\Controllers\Attendance;

use Elibyy\TCPDF\Facades\TCPDF;
use Hekmatinasser\Verta\Facades\Verta;
use Sq\Employee\Http\Controllers\Attendance\Contracts\AttendanceSettings;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\Department;
use Sq\Query\Policy\UserDepartment;
use TCPDF_FONTS;

class SingleEmployeeReport extends AttendanceSettings
{
    /**
     * Summary of employee
     * @var CardInfo
     */
    protected $employee;
    public function __construct(
        protected $id
    ) {
        parent::__construct();
        $this->employee = CardInfo::where('id', $id)->with([
            'attendance' => function ($query) {
                $query
                    ->orderBy('date', 'ASC')
                    ->whereBetween("date", [$this->start, $this->end]);
            }
        ])
            ->first();
            $this->department=$this->employee->orginization;

        if (!in_array($this->employee->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }

    }
    public function maker()
    {
        TCPDF::AddPage();
        $this->header();
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
}
