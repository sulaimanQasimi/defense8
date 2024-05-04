<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Attendance\Report;
use App\Models\Card\CardInfo;
use App\Models\Department;
use Elibyy\TCPDF\Facades\TCPDF;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;
use TCPDF_FONTS;

class CurrentMonthEmployeeAttendance extends Controller
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

    public function __invoke()
    {
        $query = CardInfo::query();
        return (new Report(employee: fn() => $query, date: $this->date, start: $this->start, end: $this->end, year: $this->year, month: $this->month))->maker()->download();
    }
    public function single_employee(CardInfo $cardInfo)
    {
        $query = CardInfo::where('id', $cardInfo->id);
        return (new Report(employee: fn() => $query, date: $this->date, start: $this->start, end: $this->end,year: $this->year, month: $this->month))
        ->maker()
        ->download();
    }
    public function single_department(Department $department)
    {
        $query = CardInfo::where('department_id', $department->id);
        return (new Report(employee: fn() => $query, date: $this->date, start: $this->start, end: $this->end,year: $this->year, month: $this->month))->maker()->download();
    }
}
