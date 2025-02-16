<?php

namespace Sq\Card\Http\Controllers;

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
use Illuminate\Support\Facades\Log;

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

        $this->checkUserDepartment($cardInfo, $card, $printTypeEnum);

        // Get / Replace the field to Value
        $field = new PrintCardField(employee: $cardInfo, frame: $card, vehical: $employeeVehicalCard, gun: $gun, mainCard: $mainCard);

        $this->logActivity($card, $mainCard, $gun, $employeeVehicalCard);

        $card_record = PrintCard::create(attributes: [
            'user_id' => auth()->id(),
            'card_info_id' => $cardInfo->id,
            'print_card_frame_id' => $card->id,
            'issue' => $this->getIssueDate($printTypeEnum, $mainCard, $employeeVehicalCard, $gun),
            'expire' => $this->getExpireDate($printTypeEnum, $mainCard, $employeeVehicalCard, $gun),
        ]);


        return view('sqcard::print.card', compact('cardInfo', 'card', 'field'));
    }
}
