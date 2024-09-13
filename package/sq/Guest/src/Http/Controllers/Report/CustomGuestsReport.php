<?php

namespace Sq\Guest\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Sq\Guest\Http\Controllers\Report\Contracts\Template;
use Sq\Guest\Models\GuestGate;
use Sq\Query\DateFromAndToModelQuery;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
use Sq\Query\Policy\UserDepartment;

class CustomGuestsReport extends Controller
{
    use Template;
    public function __invoke(Request $request)
    {
        $createGuestQuery = new DateFromAndToModelQuery(GuestGate::class, 'entered_at');
        $department = $request->input('department', null);
        if (request()->input('department', null) == null || request()->input('department', null) == 'null') {
            $department = null;

        }

        $query = $createGuestQuery->query()

            // Department Filter
            ->when(
                $department,
                function ($query) use ($department) {
                    return $query->whereHas('guest.host', function ($query) use ($department) {
                        return $query->where("department_id", $department);
                    });
                }
            )
            ->whereHas('guest', function ($query) {
                $query->whereHas('host', function ($query) {
                    return $query->whereIn('department_id', UserDepartment::getUserDepartment());
                });
            });


        if ($request->input('file') == 'excel') {
            return $this->excel($query);
        }

        return $this->pdf($query);
    }
    public function pdf($query)
    {
        $guests = $query->get();
        $this->header(trans('Daily Guest Report'));
        TCPDF::SetTitle(trans("Daily Guest Report"));
        TCPDF::AddPage();
        $i = 1;
        foreach ($guests as $guest) {
            $this->row(pass: $guest, i: $i);
            $i++;
        }

        return TCPDF::Output(trans("Daily Guest Report") . '.pdf', 'I');

    }
    public function excel($query)
    {
        return (new \Sq\Guest\Exports\GateGuestExport($query))->download('guest.xlsx');
    }

}
