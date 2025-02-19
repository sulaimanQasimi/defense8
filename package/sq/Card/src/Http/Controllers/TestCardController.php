<?php

namespace Sq\Card\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
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
    public function custom(Request $request, \Sq\Card\Models\CustomPaperCard $customPaperCard): View
    {

        if (!in_array($customPaperCard->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }

        return view('sqcard::test.custom-card', [
            'attr' => $customPaperCard->attr,
            'details' => $customPaperCard->details,
            'cardFrame' => $customPaperCard,
            'remark' => $customPaperCard->remark,
        ]);
    }
    /**
     * This function is responsible for rendering a PVC card view.
     *
     * @param Request $request The incoming request object.
     * @param \Sq\Card\Models\PrintCardFrame $printCardFrame The Print Card Frame model instance.
     *
     * @return View Returns a view with the PVC card data.
     */
    public function pvc(Request $request, \Sq\Card\Models\PrintCardFrame $printCardFrame): View
    {

        if (!in_array($printCardFrame->department_id, UserDepartment::getUserDepartment())) {
            abort(404);
        }

        $cardInfo = new \stdClass();
        $cardInfo->id = 1;
        $cardInfo->image_path = asset('logo.png');
        $cardInfo->registare_no  = "G2-6666660";
        // dd($printCardFrame->attr);

        $field = new \stdClass();
        $field->header = $printCardFrame->attr['government']['title'];
        $field->details = $printCardFrame->details;
        $field->remark = $printCardFrame->remark;
        return view('sqcard::test.pvc-card', [
            'attr' => $printCardFrame->attr,
            'details' => $printCardFrame->details,
            'card' => $printCardFrame,
            'cardInfo' => $cardInfo,
            'remark' => $printCardFrame->remark,
            'field' => $field,
        ]);
    }
}
