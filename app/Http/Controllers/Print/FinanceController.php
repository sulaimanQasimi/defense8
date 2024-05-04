<?php

namespace App\Http\Controllers\Print;

use App\Http\Controllers\Controller;
use App\Models\Finance\AccountingAdministrationIncome;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Accounting;

class FinanceController extends Controller
{
    public function general($id, $title): View
    {
        $account = AccountingAdministrationIncome::findOrFail($id);
        return view('print.Finance.General.bill', ['account' => $account, 'title' => $title]);
    }
}
