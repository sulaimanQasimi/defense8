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
    /**
     * This function is responsible for rendering a custom paper card view.
     *
     * @param Request $request The incoming request object.
     * @param \Sq\Card\Models\CustomPaperCard $customPaperCard The custom paper card model instance.
     *
     * @return View Returns a view with the custom paper card data.
     */
    public function custom(Request $request, \Sq\Card\Models\CustomPaperCard $customPaperCard)
    {
        return view('sqcard::test.custom-card', [
            'attr' => $customPaperCard->attr,
            'details' => $customPaperCard->details,
            'cardFrame' => $customPaperCard,
            'remark' => $customPaperCard->remark,
        ]);
    }
}
