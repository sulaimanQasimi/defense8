<?php

namespace Sq\Employee\Http\Controllers;

use Sq\Employee\Http\Controllers\Attendance\Report;
use Sq\Employee\Http\Controllers\Attendance\SingleEmployeeReport;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\Department;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Sq\Query\Policy\UserDepartment;

class CurrentMonthEmployeeAttendance
{
    // Get the current month's attendance for all employees

    public $start;
    public $end;
    public $date;
    public $year, $month;


    public function __construct(Request $request)
    {
        $this->year = $request->year ?? verta()->year;
        $this->month = $request->month ?? verta()->month;
        $this->setDate($this->year, $this->month);
    }
    private function setDate($year, $month): void
    {
        $date = $this->date = Verta::setDateJalali($year, $month, 25);
        $this->start = Verta::parse($date->startMonth()->format("Y-m-d"))->toCarbon();
        $this->end = Verta::parse($date->endMonth()->format("Y-m-d"))->toCarbon();
    }
    public function single_employee(CardInfo $cardInfo)
    {
        if (!in_array($cardInfo->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }
        $employee = CardInfo::where('id', $cardInfo->id)
            ->with([
                'attendance' => function ($query) {
                    $query
                        ->orderBy('date', 'ASC')
                        ->whereBetween("date", [$this->start, $this->end]);
                }
            ])
            ->first();

        return (new SingleEmployeeReport(employee: $employee, date: $this->date, start: $this->start, end: $this->end, year: $this->year, month: $this->month))
            ->maker()
            ->download();
    }
    public function single_department(Department $department)
    {
        if (!in_array($department->id, UserDepartment::getUserDepartment())) {
            abort(404);
        }
        $query = CardInfo::where('department_id', $department->id)->orderBy('name');
        return (new Report(employee: fn() => $query, date: $this->date, start: $this->start, end: $this->end, year: $this->year, month: $this->month, department: $department))->maker()->download();
    }
}
