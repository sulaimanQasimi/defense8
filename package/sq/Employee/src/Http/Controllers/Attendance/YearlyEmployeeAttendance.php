<?php

namespace Sq\Employee\Http\Controllers\Attendance;
use Elibyy\TCPDF\Facades\TCPDF;
use Hekmatinasser\Verta\Facades\Verta;
use Sq\Employee\Http\Controllers\Attendance\Contracts\AttendanceSettings;
use Sq\Employee\Models\CardInfo;
use Sq\Query\Policy\UserDepartment;
class YearlyEmployeeAttendance extends AttendanceSettings
{
    private $employee;
    public function __construct(
        protected $id
    ) {
        parent::__construct();
        $this->employee = CardInfo::where('id', $id)->with([
            'attendance' => function ($query) {
                $query
                    ->orderBy('date', 'ASC')
                    ->whereYear("date",now()->year);
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




        return $this;
    }

}
