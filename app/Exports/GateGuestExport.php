<?php

namespace App\Exports;

use App\Models\GatePass;
use App\Models\GuestGate;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class GateGuestExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    use Exportable;
    public function headings(): array
    {
        return [
            trans('#'),
            trans('Name'),
            trans('Last Name'),
            trans('Job'),
            trans('Address'),
            trans('Host'),
            trans('Department'),
            trans('Job'),
            trans('Phone'),
            trans('Address'),
            trans('Date'),
            trans('Enter'),
            trans('Exit'),
        ];
    }
    public function query()
    {

        //
        $start = null;
        $end = null;
        if (request()->has('date')) {
            if (request()->input('date') != null && request()->input('date') != 'null' && request()->input('date') != '') {
                $date = explode(',', request()->input('date'));

                if (Arr::hasAny($date, 0)) {
                    $start = Verta::parse(Str::before(request()->input('date'), ','))->toCarbon();
                }
                if (Arr::hasAny($date, 1)) {

                    $end = Verta::parse(Str::after(request()->input('date'), ','))->toCarbon();
                }
            }
        }
        $guests = [];

        $department = request()->input('department', null);

        $guests = GuestGate::query()

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
            });

        return $guests;
    }
    public function map($guest): array
    {
        return [

            'id' => $guest->id,
            'name' => $guest->guest->name,
            'last_name' => $guest->guest->last_name,
            'career' => $guest->guest->career,
            'address' => $guest->guest->address,
            'host' => $guest->guest->host->head_name,
            'department' => $guest->guest->host->department->fa_name,
            'job' => $guest->guest->host->job,
            'phone' => $guest->guest->host->phone,
            'host_address' => $guest->guest->host->address,
            'registered_at' => verta($guest->entered_at)->format("Y/m/d h:i a"),
            'enter' => ($guest->guest->EnterGate->entered_at) ? verta($guest->guest->EnterGate->entered_at)->format("Y/m/d h:i a") : '',
            'exit' => ($guest->guest->ExitGate->exit_at) ? verta($guest->guest->ExitGate->exit_at)->format("Y/m/d h:i a") : '',
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }
}
