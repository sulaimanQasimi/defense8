<?php

namespace App\Http\Controllers\Report;

use App\Exports\GateGuestExport;
use App\Http\Controllers\Controller;
use Sq\Query\DateFromAndToModelQuery;
use App\Http\Controllers\Report\Contracts\Template;
use App\Models\Guest;
use App\Models\GuestGate;
use Elibyy\TCPDF\Facades\TCPDF;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use TCPDF_FONTS;

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
            );

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
        return (new GateGuestExport($query))->download('guest.xlsx');
    }

}
