<?php

namespace Sq\Oil\Http\Controllers\Oil;

use App\Http\Controllers\Controller;
use Sq\Employee\Models\CardInfo;
use Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Vehical\OilType;
use Vehical\Vehical;

class OilDisterbution extends Controller
{
    public function index(Request $request): View
    {
        $code = $request->input("code");

        $employee = CardInfo::query()->where('registare_no', "=", $code)->first();
        return view('sqoil::oil.new_template', compact('employee'));
    }
    public function store(Request $request, CardInfo $cardInfo)
    {
        $amount = $request->input('amount');
        $diesel = Vehical::remain_diesel_oil();
        $petrol = Vehical::remain_petrol_oil();

        $data = Validator::make($request->all(), [
            'amount' => 'required|numeric|not_in:0',
        ]);

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
            'filled_date' => now()
        ]);

        return redirect()->route('sq.oil.print.slip', ['oilDisterbution'=> $oil]);
    }
}
