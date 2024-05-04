<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeCurrentMonthExport;
use App\Models\Department;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        $this->authorize('admin',$department);
        return Excel::download(new EmployeeCurrentMonthExport($department->id,$this->start,$this->end), 'current-month-employee.xlsx');
    }
}
