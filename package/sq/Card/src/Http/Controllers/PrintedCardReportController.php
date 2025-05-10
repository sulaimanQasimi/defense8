<?php

namespace Sq\Card\Http\Controllers;

use App\Http\Controllers\Controller;
use Sq\Card\Models\PrintCard;
use Sq\Employee\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Hekmatinasser\Verta\Verta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * PrintedCardReportController
 *
 * This controller handles the generation and display of printed card reports.
 * It utilizes the Verta package to handle Persian/Afghan calendar dates.
 * Access to this controller is restricted by the 'printed-card-view' permission.
 */
class PrintedCardReportController extends Controller
{
    /**
     * Constructor - Set application locale to Persian (Farsi)
     * and check for the required permission
     */
    public function __construct()
    {
        app()->setLocale('fa');

        // Check if user has permission to view printed card reports
        $this->middleware('permission:printed-card-view');
    }

    /**
     * Display monthly printed card report grouped by department
     *
     * @param Request $request Contains filtering parameters (year and month)
     * @return View Returns the view with report data
     */
    public function index(Request $request): View
    {
        // Get current Verta (Shamsi) date instance
        $verta = new Verta();

        // Get year and month from request or use current year/month as default
        $year = $request->get('year', $verta->year);
        $month = $request->get('month', $verta->month);

        // Create Verta date object for the selected year/month
        $VertaDate = verta();
        $VertaDate->year = $year;
        $VertaDate->month = $month;

        // Calculate first and last day of the selected month
        $startVerta = $VertaDate->startMonth()->datetime();  // First day of month (00:00:00)
        $endVerta = $VertaDate->endMonth()->datetime();      // Last day of month (23:59:59)

        // Fetch printed cards data within the selected month
        $report = PrintCard::query()
            ->whereBetween('created_at', [$startVerta, $endVerta])
            ->with(['card_info.orginization'])  // Eager load related organization data
            ->get()
            // Group results by department's Persian name (fa_name)
            ->groupBy('card_info.orginization.fa_name')
            // Count cards for each department
            ->map(function ($cards) {
                return $cards->count();
            });

        // Get all departments for filter dropdown
        $departments = Department::all();

        // Generate year range for filter dropdown (5 years back from current year)
        $years = range($verta->year - 5, $verta->year);

        // Persian/Afghan month names with numeric indices for dropdown
        $months = [
            1 => 'حمل',    // Hamal (Aries)
            2 => 'ثور',    // Sawr (Taurus)
            3 => 'جوزا',   // Jawzā (Gemini)
            4 => 'سرطان',  // Saraṭān (Cancer)
            5 => 'اسد',    // Asad (Leo)
            6 => 'سنبله',  // Sonbola (Virgo)
            7 => 'میزان',  // Mīzān (Libra)
            8 => 'عقرب',   // 'Aqrab (Scorpio)
            9 => 'قوس',    // Qaws (Sagittarius)
            10 => 'جدی',   // Jady (Capricorn)
            11 => 'دلو',   // Dalvæ (Aquarius)
            12 => 'حوت'    // Hūt (Pisces)
        ];

        // Return view with all necessary data for rendering the report
        return view('sqcard::reports.printed-cards', compact('report', 'departments', 'years', 'months', 'year', 'month'));
    }
}
