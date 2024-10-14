<?php

namespace Sq\Employee\Livewire\Department;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;
use Livewire\Component;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\Department;
use Sq\Query\Policy\UserDepartment;

class SetAttendance extends Component
{
    use AuthorizesRequests;
    public function mount(Department $department): void
    {
        $this->authorize(ability: 'admin', arguments: $department);
    }
    public function render(): View
    {
        $employees = CardInfo::query()
            ->whereIn(column: 'department_id', values: UserDepartment::getUserDepartment())
            ->orderBy(column: 'name')
            ->with(['gate','today_attendance'])
            ->paginate(perPage: 21);
            
        return view('sqemployee::livewire.department.set-attendance', compact('employees'));
    }
}
