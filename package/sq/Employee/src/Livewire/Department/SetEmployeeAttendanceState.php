<?php

namespace Sq\Employee\Livewire\Department;

use Livewire\Component;
use Sq\Employee\Models\Attendance;

class SetEmployeeAttendanceState extends Component
{
    public $employee;

    public $state;
    public function mount($employee): void
    {
        $this->$employee = $employee;
        if ($this->employee->gate) {
            Attendance::updateOrCreate(
                [
                    'card_info_id' => $this->employee->id,
                    'date' => now()->format('Y-m-d'),
                ],
                [

                    'gate_id' => $this->employee->gate->id,
                ]
            );
        }
    }

    public function render()
    {
        return view('sqemployee::livewire.department.set-employee-attendance-state');
    }
    public function save($state): void
    {
        $today_attendance = Attendance::updateOrCreate(
            [
                'card_info_id' => $this->employee->id,
                'date' => now()->format('Y-m-d'),
            ],
            [

                'gate_id' => $this->employee->gate->id,
            ]
        );


        if ($today_attendance->state != "U" && $state == 'enter') {
            $today_attendance->enter = now();
            $today_attendance->state = "P";
        } elseif ($today_attendance->enter && $today_attendance->state != "U" && $state == 'exit') {
            $today_attendance->exit = now();

        } elseif ($today_attendance->state != "P" && $state == 'upsent') {
            $today_attendance->state = "U";
        }
        $today_attendance->save();
    }
}
