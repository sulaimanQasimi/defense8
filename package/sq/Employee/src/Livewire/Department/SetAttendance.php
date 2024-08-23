<?php

namespace Sq\Employee\Livewire\Department;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\Department;

class SetAttendance extends Component
{
    use AuthorizesRequests;
    public $department;
    public function mount(Department $department): void
    {
        $this->authorize('admin', $department);
        $this->department=$department;
    }
    public function render()
    {
        $employees=CardInfo::where('department_id',$this->department->id)->orderBy('name')->paginate(21);
        return view('sqemployee::livewire.department.set-attendance',[
            'employees'=>$employees
        ]);
    }
}
