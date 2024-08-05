<?php
namespace Acme\GuestReport\Http\Controller;

// use Sq\Query\DateFromAndToModelQuery;
use Sq\Employee\Models\Department;
use Sq\Query\DateFromAndToModelQuery;

class ApiController
{
    public function departments()
    {
        return Department::get()->map(fn($department) => ['name' => $department->fa_name, 'id' => $department->id]);
    }

    public function guest()
    {
        $department = request()->input('department', null);
        if (request()->input('department', null) == null || request()->input('department', null) == 'null') {
            $department = null;
        }

        $createGuestQuery = new DateFromAndToModelQuery(\Sq\Guest\Models\GuestGate::class, 'entered_at');

        $guests = \App\Http\Resources\GuestResource::collection(
            $createGuestQuery->query()
                // Department Filter
                ->when(
                    $department,
                    function ($query) use ($department) {
                        return $query->whereHas('guest.host', function ($query) use ($department) {
                            return $query->where("department_id", $department);
                        });
                    }
                )->paginate(20)
        );
        return $guests;
    }
}
