<?php

namespace Sq\Card\Http\Controllers;

use App\Http\Controllers\Controller;
use Sq\Card\Http\Controllers\Contracts\PrintSettings;
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
    use PrintSettings;
    public function __construct()
    {
        app()->setLocale(locale: 'fa');
    }

    private function card_optimization($cardInfo, $printCardFrame, $employeeVehicalCard = null, $gun = null, $printTypeEnum = null, $mainCard = null): View
    {
        $card = PrintCardFrame::findOrFail(id: $printCardFrame);
        /**
         * If User have Depandant department of the employee
         */
        if (!in_array($cardInfo->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }


        if (!in_array($card->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }

        if (!$card->type == $printTypeEnum) {
            abort(404);
        }
        if (!$cardInfo->confirmed) {
            abort(404);
        }

        // Get / Replace the field to Value
        $field = new PrintCardField(employee: $cardInfo, frame: $card, vehical: $employeeVehicalCard, gun: $gun, mainCard: $mainCard);

        $card_record = PrintCard::create(attributes: [
            //
            'user_id' => auth()->id(),

            'card_info_id' => $cardInfo->id,

            'print_card_frame_id' => $card->id,
            // Issue Date In specifict Format
            'issue' => match ($printTypeEnum) {
                PrintTypeEnum::Employee => $mainCard?->card_perform,
                PrintTypeEnum::EmployeeCar => $employeeVehicalCard?->register_date,
                PrintTypeEnum::Gun => $gun?->register_date,
            },
            //  Expire Date
            'expire' => match ($printTypeEnum) {
                PrintTypeEnum::Employee => $mainCard?->card_expired_date,
                PrintTypeEnum::EmployeeCar => $employeeVehicalCard?->expire_date,
                PrintTypeEnum::Gun => $gun?->expire_date,
            },
        ]);

        return view('sqcard::print.card', compact('cardInfo', 'card', 'field'));
    }
}
