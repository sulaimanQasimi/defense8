<?php

namespace Sq\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Sq\Employee\Exports\EmployeeCurrentMonthExport;
use Sq\Employee\Models\Department;

class ExcelEmployeeExportController extends Controller
{

    // Get the current month's attendance for all employees

    public $start;
    public $end;
    public $date;

    public function __construct(Request $request)
    {
        $this->setDate($request->year ?? verta()->year, $request->month ?? verta()->month);
    }
    private function setDate($year, $month): void
    {
        $date = $this->date = Verta::setDateJalali($year, $month, 25);
        $this->start = Verta::parse($date->startMonth()->format("Y-m-d"))->toCarbon();
        $this->end = Verta::parse($date->endMonth()->format("Y-m-d"))->toCarbon();
    }


    public function attendance(Department $department)
    {
        return Excel::download(new EmployeeCurrentMonthExport($department->id, $this->start, $this->end), 'current-month-employee.xlsx');
    }
}
