<?php

namespace Sq\Employee\Livewire\Department;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\Department;
use Sq\Query\Policy\UserDepartment;

class SetAttendance extends Component
{
    use AuthorizesRequests;
    public $department;
    public function mount(Department $department): void
    {
       
        $this->authorize(ability: 'admin', arguments: $department);
        $this->department = $department;
    }
    public function render()
    {
        $employees = CardInfo::query()
            ->whereIn('department_id', UserDepartment::getUserDepartment())
            ->orderBy('name')->paginate(21);
        return view('sqemployee::livewire.department.set-attendance', compact('employees'));
    }
}
