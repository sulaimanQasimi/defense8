<?php

namespace App\Http\Controllers\Report;

use App\Exports\GateGuestExport;
use App\Http\Controllers\Controller;
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
        //
        $start = null;
        $end = null;
        if ($request->has('date')) {
            if ($request->input('date') != null && $request->input('date') != 'null' && $request->input('date') != '') {
                $date = explode(',', $request->input('date'));

                if (Arr::hasAny($date, 0)) {
                    $start = Verta::parse(Str::before($request->input('date'), ','))->toCarbon();
                }
                if (Arr::hasAny($date, 1)) {

                    $end = Verta::parse(Str::after($request->input('date'), ','))->toCarbon();
                }
            }
        }
        $guests = [];
        $department = $request->input('department', null);
        $guests = GuestGate::query()
            // Department Filter
            ->when(
                $department,
                function ($query) use ($department) {
                    return $query->whereHas('guest.host', function ($query) use ($department) {
                        return $query->where("department_id", $department);
                    });
                }
            )

            ->when(
                ($start != null && $end != null),
                function ($query) use ($start, $end) {
                    return $query->whereBetween('entered_at', [$start, Carbon::parse($end)->endOfDay()]);
                }
            )
            ->when(($start && $end == null), function ($query) use ($start, $end) {
                return $query->whereDate('entered_at', $start);
            })->get();


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
    public function excel_report()
    {
        return (new GateGuestExport)->download('guest.xlsx');
    }

}
