<?php

namespace App\Livewire\Department;

use App\Models\Card\CardInfo;
use App\Models\Department;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

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
        $employees=CardInfo::where(
            'department_id',$this->department->id)->paginate();
        return view('sqemployee::livewire.department.set-attendance',[
            'employees'=>$employees
        ]);
    }
}
