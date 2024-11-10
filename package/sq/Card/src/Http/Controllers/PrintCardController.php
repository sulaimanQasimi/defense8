<?php

namespace Sq\Card\Http\Controllers;

use App\Http\Controllers\Controller;
use Sq\Card\Models\PrintCard;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\EmployeeVehicalCard;
use Sq\Card\Models\PrintCardFrame;
use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Sq\Card\Support\PrintCardField;
use Sq\Employee\Models\GunCard;
use Sq\Employee\Models\MainCard;
use Sq\Query\Policy\UserDepartment;

class PrintCardController
{
    public function __construct()
    {
        app()->setLocale(locale: 'fa');
    }

    /**
     * Summary of employee
     * @param \Illuminate\Http\Request $request
     * @param \Sq\Employee\Models\CardInfo $cardInfo
     * @param int $printCardFrame
     * @return \Illuminate\View\View
     */
    public function employee(Request $request, MainCard $mainCard , int $printCardFrame): View
    {
        return $this->card_optimization(cardInfo: $mainCard->card_info, printCardFrame: $printCardFrame, printTypeEnum: PrintTypeEnum::Employee,mainCard:$mainCard, gun: null, employeeVehicalCard: null);
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
        return $this->card_optimization(cardInfo: $gunCard->card_info, printCardFrame: $printCardFrame, printTypeEnum: PrintTypeEnum::Gun, gun: $gunCard);
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
        return $this->card_optimization(cardInfo: $employeeVehicalCard->card_info, printCardFrame: $printCardFrame, printTypeEnum: PrintTypeEnum::EmployeeCar, employeeVehicalCard: $employeeVehicalCard);
    }
    /**
     * Summary of card_optimization
     * @param mixed $cardInfo
     * @param mixed $printCardFrame
     * @param mixed $employeeVehicalCard
     * @param mixed $gun
     * @param mixed $printTypeEnum
     * @return \Illuminate\View\View
     */
    private function card_optimization($cardInfo, $printCardFrame, $employeeVehicalCard = null, $gun = null, $printTypeEnum,$mainCard): View
    {
        $card = PrintCardFrame::findOrFail(id: $printCardFrame);
        /**
         * If User have Depandant department of the employee
         */
        if (!in_array($cardInfo->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }


        if (!$card->type == $printTypeEnum) {
            abort(404);
        }

        // Get / Replace the field to Value
        $field = new PrintCardField(employee: $cardInfo, frame: $card, vehical: $employeeVehicalCard, gun: $gun,mainCard:$mainCard);

        $card_record = PrintCard::create(attributes: [
            'user_id' => auth()->id(),
            'card_info_id' => $cardInfo->id,
            'print_card_frame_id' => $card->id,
            'issue' => match ($printTypeEnum) {
                PrintTypeEnum::Employee => $mainCard?->card_perform,
                PrintTypeEnum::EmployeeCar => $employeeVehicalCard?->register_date,
                PrintTypeEnum::Gun => $gun?->register_date,
            },
            'expire' => match ($printTypeEnum) {
                PrintTypeEnum::Employee => $mainCard?->card_expired_date,
                PrintTypeEnum::EmployeeCar => $employeeVehicalCard?->expire_date,
                PrintTypeEnum::Gun => $gun?->expire_date,
            },
        ]);

        return view('sqcard::print.card', compact('cardInfo', 'card', 'field'));
    }
}
