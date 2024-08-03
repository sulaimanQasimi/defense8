<?php

namespace Sq\Employee\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;

class AttendanceGenerator extends Component
{

    #[Url]
    public $month;
    #[Url]
    public $year;
    #[Url]
    public $department;
    public $route='#';
    public function render()
    {
        return view('sqemployee::livewire.attendance-generator');
    }
    public function save(): void
    {
        $this->validate(
            [
                'month' => 'required',
                'year' => 'required',
                'department' => 'required|exists:departments,id'
            ]
        );

        $this->route = route('employee.attendance.current.month..department.single', ['department' => $this->department, 'month' => $this->month, 'year' => $this->year]);
    }

}
