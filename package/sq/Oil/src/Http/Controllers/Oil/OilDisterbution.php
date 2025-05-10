<?php

namespace Sq\Oil\Http\Controllers\Oil;

use App\Http\Controllers\Controller;
use Sq\Employee\Models\CardInfo;
use Illuminate\Support\Facades\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Sq\Query\Policy\UserDepartment;
use Vehical\OilType;
use Vehical\Vehical;
use Sq\Oil\Models\PumpStation;
use Sq\Oil\Models\Oil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OilDisterbution extends Controller
{
    public function index(Request $request): View
    {
        $code = $request->input("code");

        // Get the employee
        $employee = CardInfo::query()
            ->whereIn('department_id', UserDepartment::getUserDepartment())
            ->where('registare_no', "=", $code)
            ->first();

        // Check if employee has a pump_station_id
        $noAccessReason = null;
        if ($employee && !$employee->pump_station_id) {
            $noAccessReason = 'no_pump_station';
            return view('sqoil::oil.new_template', compact('employee', 'noAccessReason'));
        }

        // Get statistics for the pump station if the employee has one
        $pumpStats = null;
        if ($employee && $employee->pump_station_id) {
            $pumpStats = $this->getPumpStationStats($employee->pump_station_id);
        }

        return view('sqoil::oil.new_template', compact('employee', 'pumpStats'));
    }

    public function store(Request $request, CardInfo $cardInfo)
    {
        // Check if employee has a pump_station_id
        if (!$cardInfo->pump_station_id) {
            return redirect()->back()->with('error', trans('Employee does not have an assigned pump station'));
        }

        $amount = $request->input('amount');

        $diesel = Vehical::remain_diesel_oil();

        $petrol = Vehical::remain_petrol_oil();

        $data = Validator::make($request->all(), [
            'amount' => 'required|numeric|not_in:0',
        ]);


        if (!in_array($cardInfo?->department_id, UserDepartment::getUserDepartment())) {
            return redirect()->back();
        }

        if ($data->fails()) {

            return redirect()->back()->with('error', trans('validation.required', ['attribute' => trans("Amount")]));
        }


        // If oil type is Diesel
        if ($cardInfo->oil_type == OilType::Diesel) {

            // if input amount exceeded then Diesel Oil Storage
            if ($amount > $diesel) {

                // Redirect With error message
                return redirect()->back()->with('error', trans('We are out of Oil'));
            }
        }

        // If oil type is Petrole
        if ($cardInfo->oil_type == OilType::Petrole) {

            // if input amount exceeded then Petrole Oil Storage
            if ($amount > $petrol) {

                // Redirect With error message
                return redirect()->back()->with('error', trans('We are out of Oil'));
            }
        }

        // if oil type undefined
        if ($cardInfo->oil_type == null) {

            // Redirect With error message
            return redirect()->back()->with('error', trans('Oil type undefined'));
        }

        if ($amount > $cardInfo->monthly_rate) {
            // Redirect With error message
            return redirect()->back()->with('error', trans('Amount of oil exceeded then your monthly rate'));
        }

        Date::setWeekStartsAt(0);

        // Usage of oil
        $d_oil = $cardInfo->current_month_oil_consumtion;

        if ($d_oil != 0) {
            $remain = $cardInfo->monthly_rate - $d_oil;
            if ($remain == 0) {
                return redirect()->back()->with('error', trans('You recieved your weekly rate'));
            }
            if ($amount > $remain) {
                return redirect()->back()->with('error', trans('You allow to take', ['value' => trans("Liter", ['value' => $remain])]));
            }
        }

        $oil = \Sq\Oil\Models\OilDisterbution::create([
            "card_info_id" => $cardInfo->id,
            "oil_type" => $cardInfo->oil_type,
            "oil_amount" => $request->input('amount'),
            'filled_date' => now(),
            'pump_station_id' => $cardInfo->pump_station_id
        ]);

        return redirect()->route('sq.oil.print.slip', ['oilDisterbution' => $oil]);
    }

    /**
     * Get statistics for a specific pump station
     *
     * @param int $pumpStationId
     * @return array
     */
    private function getPumpStationStats($pumpStationId)
    {
        $pumpStation = PumpStation::findOrFail($pumpStationId);

        // ===== OIL INCOME STATISTICS (from Oil model) =====

        // Total oil income to this pump station
        $totalOilIncome = DB::table('oil')
            ->where('pump_station_id', $pumpStationId)
            ->sum('oil_amount');

        // Total diesel income to this pump station
        $totalDieselIncome = DB::table('oil')
            ->where('pump_station_id', $pumpStationId)
            ->where('oil_type', OilType::Diesel)
            ->sum('oil_amount');

        // Total petrol income to this pump station
        $totalPetrolIncome = DB::table('oil')
            ->where('pump_station_id', $pumpStationId)
            ->where('oil_type', OilType::Petrole)
            ->sum('oil_amount');

        // Current month income statistics
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $currentMonthIncomeTotal = DB::table('oil')
            ->where('pump_station_id', $pumpStationId)
            ->whereBetween('filled_date', [$startOfMonth, $endOfMonth])
            ->sum('oil_amount');

        $currentMonthDieselIncome = DB::table('oil')
            ->where('pump_station_id', $pumpStationId)
            ->where('oil_type', OilType::Diesel)
            ->whereBetween('filled_date', [$startOfMonth, $endOfMonth])
            ->sum('oil_amount');

        $currentMonthPetrolIncome = DB::table('oil')
            ->where('pump_station_id', $pumpStationId)
            ->where('oil_type', OilType::Petrole)
            ->whereBetween('filled_date', [$startOfMonth, $endOfMonth])
            ->sum('oil_amount');

        // ===== OIL DISTRIBUTION STATISTICS (from OilDisterbution model) =====

        // Total oil distributed from this pump station
        $totalDistributed = DB::table('oil_disterbutions')
            ->where('pump_station_id', $pumpStationId)
            ->sum('oil_amount');

        // Total diesel distributed from this pump station
        $totalDieselDistributed = DB::table('oil_disterbutions')
            ->where('pump_station_id', $pumpStationId)
            ->where('oil_type', OilType::Diesel)
            ->sum('oil_amount');

        // Total petrol distributed from this pump station
        $totalPetrolDistributed = DB::table('oil_disterbutions')
            ->where('pump_station_id', $pumpStationId)
            ->where('oil_type', OilType::Petrole)
            ->sum('oil_amount');

        // Current month distribution statistics
        $currentMonthDistTotal = DB::table('oil_disterbutions')
            ->where('pump_station_id', $pumpStationId)
            ->whereBetween('filled_date', [$startOfMonth, $endOfMonth])
            ->sum('oil_amount');

        $currentMonthDieselDist = DB::table('oil_disterbutions')
            ->where('pump_station_id', $pumpStationId)
            ->where('oil_type', OilType::Diesel)
            ->whereBetween('filled_date', [$startOfMonth, $endOfMonth])
            ->sum('oil_amount');

        $currentMonthPetrolDist = DB::table('oil_disterbutions')
            ->where('pump_station_id', $pumpStationId)
            ->where('oil_type', OilType::Petrole)
            ->whereBetween('filled_date', [$startOfMonth, $endOfMonth])
            ->sum('oil_amount');

        // ===== REMAINING CALCULATIONS =====

        // Calculate remaining oil amounts
        $remainingDiesel = $totalDieselIncome - $totalDieselDistributed;
        $remainingPetrol = $totalPetrolIncome - $totalPetrolDistributed;
        $remainingTotal = $totalOilIncome - $totalDistributed;

        // Count of distributions
        $distributionCount = DB::table('oil_disterbutions')
            ->where('pump_station_id', $pumpStationId)
            ->count();

        // Count of users served at this pump station
        $usersServed = DB::table('oil_disterbutions')
            ->where('pump_station_id', $pumpStationId)
            ->distinct('card_info_id')
            ->count('card_info_id');

        return [
            'name' => $pumpStation->name,
            'location' => $pumpStation->location,
            'capacity' => $pumpStation->capacity,
            'is_active' => $pumpStation->is_active,

            // Income statistics (Oil)
            'total_income' => $totalOilIncome,
            'total_diesel_income' => $totalDieselIncome,
            'total_petrol_income' => $totalPetrolIncome,
            'current_month_income' => $currentMonthIncomeTotal,
            'current_month_diesel_income' => $currentMonthDieselIncome,
            'current_month_petrol_income' => $currentMonthPetrolIncome,

            // Distribution statistics (OilDisterbution)
            'total_distributed' => $totalDistributed,
            'total_diesel_distributed' => $totalDieselDistributed,
            'total_petrol_distributed' => $totalPetrolDistributed,
            'current_month_distributed' => $currentMonthDistTotal,
            'current_month_diesel_distributed' => $currentMonthDieselDist,
            'current_month_petrol_distributed' => $currentMonthPetrolDist,

            // Remaining amounts
            'remaining_diesel' => $remainingDiesel,
            'remaining_petrol' => $remainingPetrol,
            'remaining_total' => $remainingTotal,

            // Other statistics
            'distribution_count' => $distributionCount,
            'users_served' => $usersServed,
        ];
    }
}
