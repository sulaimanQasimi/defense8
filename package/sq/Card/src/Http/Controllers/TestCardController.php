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

class TestCardController extends Controller
{
    public function __construct()
    {
        app()->setLocale(locale: 'fa');
    }
    public function custom(Request $request, \Sq\Card\Models\CustomPaperCard $customPaperCard)
    {
        return view('sqcard::test.custom-card', [
            'attr'=> $customPaperCard->attr,
            'details'=> $customPaperCard->details,
            'cardFrame'=> $customPaperCard,
''
            ]);
    }
}
