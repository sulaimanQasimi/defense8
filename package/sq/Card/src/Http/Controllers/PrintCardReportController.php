<?php

namespace Sq\Card\Http\Controllers;

use App\Http\Controllers\Controller;
use Sq\Card\Models\PrintCard;
use Sq\Employee\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Hekmatinasser\Verta\Verta;

class PrintCardReportController extends Controller
{
    public function __construct()
    {
        app()->setLocale('fa');
    }

    public function index(Request $request): View
    {
        $verta = new Verta();
        $year = $request->get('year', $verta->year);
        $month = $request->get('month', $verta->month);

        $startDate = (new Verta())->setDate($year, $month, 1)->startMonth()->datetime();
        $endDate = (new Verta())->setDate($year, $month, 1)->endMonth()->datetime();
dd($startDate,$endDate);
        $report = PrintCard::query()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['card_info.department'])
            ->get()
            ->groupBy('card_info.department.name')
            ->map(function ($cards) {
                return $cards->count();
            });
;
        $departments = Department::all();
        $years = range($verta->year - 5, $verta->year);
        $months = range(1, 12);

        return view('sqcard::reports.printed-cards', compact('report', 'departments', 'years', 'months', 'year', 'month'));
    }
}
