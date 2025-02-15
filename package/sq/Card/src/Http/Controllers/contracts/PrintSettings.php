<?php

namespace Sq\Card\Http\Controllers\Contracts;

use App\Http\Controllers\Controller;
use Sq\Card\Models\PrintCard;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\EmployeeVehicalCard;
use Sq\Card\Models\PrintCardFrame;
use App\Support\Defense\Print\PrintTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Sq\Card\Support\PrintCardField;
use Sq\Employee\Models\GunCard;
use Sq\Employee\Models\MainCard;
use Sq\Query\Policy\UserDepartment;


trait PrintSettings
{

    abstract   private function card_optimization($cardInfo, $printCardFrame, $employeeVehicalCard = null, $gun = null, $printTypeEnum = null, $mainCard = null): View;

    /**
     * Summary of employee
     * @param \Illuminate\Http\Request $request
     * @param \Sq\Employee\Models\CardInfo $cardInfo
     * @param int $printCardFrame
     * @return \Illuminate\View\View
     */
    public function employee(Request $request, MainCard $mainCard, int $printCardFrame): View
    {
        if ($mainCard->printed) {
            abort(404);
        }
        $mainCard->update([
            'printed' => 1,
            'printed_at' => now()
        ]);

        $date = Carbon::make($mainCard->card_expired_date)->format('Y/m/d');
        // Activity
        activity()
            ->performedOn($mainCard)
            ->causedBy(auth()->user())
            ->withProperties([
                "card_perform" => $mainCard->card_perform,
                "card_expired_date" => $mainCard->card_expired_date,
                "remark" => $mainCard->remark,
                "muthanna" => $mainCard->muthanna,
            ])
            ->log("کارت با تاریخ انقضا {$date} برای کارمند پرنت شد");


        return $this->card_optimization(
            cardInfo: $mainCard->card_info,
            printCardFrame: $printCardFrame,
            printTypeEnum: PrintTypeEnum::Employee,
            mainCard: $mainCard,
            gun: null,
            employeeVehicalCard: null
        );
    }

    /**
     * Summary of gun
     * @param \Illuminate\Http\Request $request
     * @param \Sq\Employee\Models\GunCard $gunCard
     * @param int $printCardFrame
     * @return \Illuminate\View\View
     */
    public function gun(Request $request, GunCard $gunCard, int $printCardFrame): View
    {

        if ($gunCard->printed) {
            abort(404);
        }
        $gunCard->update(['printed' => 1]);

        return $this->card_optimization(
            cardInfo: $gunCard->card_info,
            printCardFrame: $printCardFrame,
            gun: $gunCard,
            printTypeEnum: PrintTypeEnum::Gun,
        );
    }

    /**
     * Summary of employee_car
     * @param \Illuminate\Http\Request $request
     * @param \Sq\Employee\Models\EmployeeVehicalCard $employeeVehicalCard
     * @param int $printCardFrame
     * @return \Illuminate\View\View
     */
    public function employee_car(Request $request, EmployeeVehicalCard $employeeVehicalCard, int $printCardFrame): View
    {
        if ($employeeVehicalCard->printed) {
            abort(404);
        }
        $employeeVehicalCard->update(['printed' => 1]);

        return $this->card_optimization(
            cardInfo: $employeeVehicalCard->card_info,
            printCardFrame: $printCardFrame,
            printTypeEnum: PrintTypeEnum::EmployeeCar,
            employeeVehicalCard: $employeeVehicalCard,
        );
    }
}
