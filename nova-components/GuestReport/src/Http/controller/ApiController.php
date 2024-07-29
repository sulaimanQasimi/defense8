<?php
namespace Acme\GuestReport\Http\Controller;

use App\Models\Department;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ApiController
{
    public function departments()
    {
        return Department::get()->map(fn($department) => ['name' => $department->fa_name, 'id' => $department->id]);
    }

    public function guest()
    {

    $start = null;
    $end = null;

    $department = request()->input('department', null);

    //
    if (request()->has('date')) {
        //
        if (request()->input('date') != null && request()->input('date') != "null" && request()->input('date') != '') {
            //
            $date = explode(',', request()->input('date'));
            //
            if (Arr::hasAny($date, 0)) {
                $start = Verta::parse(Str::before(request()->input('date'), ','))->toCarbon();
            }
            //
            if (Arr::hasAny($date, 1)) {
                $end = Verta::parse(Str::after(request()->input('date'), ','))->toCarbon();
            }
        }
    }


    $guests = [];

    $guests = \App\Http\Resources\GuestResource::collection(
       \App\Models\GuestGate::query()

            // Department Filter
            ->when(
                $department,
                function ($query) use ($department) {
                    return $query->whereHas('guest.host', function ($query) use ($department) {
                        return $query->where("department_id", $department);
                    });
                }
            )

            // Range Date Filter
            ->when(
                ($start != null && $end != null),
                function ($query) use ($start, $end) {
                    return $query->whereBetween('entered_at', [$start, Carbon::parse($end)->endOfDay()]);
                }
            )

            // Single Data Filter
            ->when(
                ($start && $end == null),
                function ($query) use ($start) {
                    return $query->whereDate('entered_at', $start);
                }
            )

            ->paginate(20)
    );
return $guests;
    }
}
