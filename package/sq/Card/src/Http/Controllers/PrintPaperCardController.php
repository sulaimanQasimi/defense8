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
use Illuminate\Support\Facades\Log;

class PrintPaperCardController extends Controller
{
    use PrintSettings;

    public function __construct()
    {
        app()->setLocale(locale: 'fa');
    }

    private function card_optimization($cardInfo, $printCardFrame, $employeeVehicalCard = null, $gun = null, $printTypeEnum = null, $mainCard = null): View
    {
        $card = \Sq\Card\Models\CustomPaperCard::findOrFail(id: $printCardFrame);

        $this->checkUserDepartment($cardInfo, $card, $printTypeEnum);

        // Get / Replace the field to Value
        $field = new PrintCardField(employee: $cardInfo, frame: $card, vehical: $employeeVehicalCard, gun: $gun, mainCard: $mainCard);
        $this->logActivity($card, $mainCard, $gun, $employeeVehicalCard);

        $card_record = PrintCard::create(attributes: [
            'user_id' => auth()->id(),
            'card_info_id' => $cardInfo->id,
            'custom_paper_card_id' => $card->id,
            'issue' => $this->getIssueDate($printTypeEnum, $mainCard, $employeeVehicalCard, $gun),
            'expire' => $this->getExpireDate($printTypeEnum, $mainCard, $employeeVehicalCard, $gun),
        ]);

        Log::info("Custom paper card printed successfully", ['card_record' => $card_record]);

        return view('sqcard::print.custom-card', compact('cardInfo', 'card', 'field','employeeVehicalCard'));
    }
}
