<?php

namespace Sq\Card\Http\Controllers\Contracts;

use Sq\Employee\Models\EmployeeVehicalCard;
use App\Support\Defense\Print\PrintTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Sq\Employee\Models\GunCard;
use Sq\Employee\Models\MainCard;
use Sq\Query\Policy\UserDepartment;
use Illuminate\Support\Facades\Log;

/**
 * Trait PrintSettings
 * Provides methods for handling the printing of various types of cards.
 */
trait PrintSettings
{
    /**
     * Abstract method for card optimization.
     *
     * @param mixed $cardInfo
     * @param int $printCardFrame
     * @param mixed|null $employeeVehicalCard
     * @param mixed|null $gun
     * @param mixed|null $printTypeEnum
     * @param mixed|null $mainCard
     * @return \Illuminate\View\View
     */
    abstract private function card_optimization($cardInfo, $printCardFrame, $employeeVehicalCard = null, $gun = null, $printTypeEnum = null, $mainCard = null): View;

    /**
     * Handles the printing process for an employee's main card.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Sq\Employee\Models\MainCard $mainCard
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
        // Log activity
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
     * Handles the printing process for a gun card.
     *
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
        $date = Carbon::make($gunCard->expire_date)->format('Y/m/d');
        // Log activity
        activity()
            ->performedOn($gunCard)
            ->causedBy(auth()->user())
            ->withProperties([
                "register_date" => $gunCard->register_date,
                "expire_date" => $gunCard->expire_date,
            ])
            ->log("کارت با تاریخ انقضا {$date} برای اسلحه پرنت شد");

        return $this->card_optimization(
            cardInfo: $gunCard->card_info,
            printCardFrame: $printCardFrame,
            gun: $gunCard,
            printTypeEnum: PrintTypeEnum::Gun,
        );
    }

    /**
     * Handles the printing process for an employee vehicle card.
     *
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

        $date = Carbon::make($employeeVehicalCard->expire_date)->format('Y/m/d');
        // Log activity
        activity()
            ->performedOn($employeeVehicalCard)
            ->causedBy(auth()->user())
            ->withProperties([
                "register_date" => $employeeVehicalCard->register_date,
                "expire_date" => $employeeVehicalCard->expire_date,
            ])
            ->log("کارت با تاریخ انقضا {$date} برای واسطه پرنت شد");

        return $this->card_optimization(
            cardInfo: $employeeVehicalCard->card_info,
            printCardFrame: $printCardFrame,
            printTypeEnum: PrintTypeEnum::EmployeeCar,
            employeeVehicalCard: $employeeVehicalCard,
        );
    }

    private function logActivity($card, $mainCard, $gun, $employeeVehicalCard)
    {
        if ($mainCard) {
            activity()
                ->performedOn($mainCard)
                ->causedBy(auth()->user())
                ->log("قالب {$card->name} پرنت شد");
        } else if ($gun) {
            activity()
                ->performedOn($gun)
                ->causedBy(auth()->user())
                ->log("قالب {$card->name} پرنت شد");
        } else if ($employeeVehicalCard) {
            activity()
                ->performedOn($employeeVehicalCard)
                ->causedBy(auth()->user())
                ->log("قالب {$card->name} پرنت شد");
        }
    }

    private function checkUserDepartment($cardInfo, $card, $printTypeEnum)
    {
        if (!in_array($cardInfo->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }

        if (!in_array($card->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }

        if ($card->type != $printTypeEnum) {
            abort(404);
        }
        if (!$cardInfo->confirmed) {
            abort(404);
        }
    }

    private function getIssueDate($printTypeEnum, $mainCard, $employeeVehicalCard, $gun)
    {
        return match ($printTypeEnum) {
            PrintTypeEnum::Employee => $mainCard?->card_perform,
            PrintTypeEnum::EmployeeCar => $employeeVehicalCard?->register_date,
            PrintTypeEnum::Gun => $gun?->register_date,
        };
    }

    private function getExpireDate($printTypeEnum, $mainCard, $employeeVehicalCard, $gun)
    {
        return match ($printTypeEnum) {
            PrintTypeEnum::Employee => $mainCard?->card_expired_date,
            PrintTypeEnum::Gun => $gun?->expire_date,
            PrintTypeEnum::EmployeeCar => $employeeVehicalCard?->expire_date,
        };
    }
}
