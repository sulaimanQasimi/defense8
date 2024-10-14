<?php

namespace Sq\Employee\Livewire\Department;

use Livewire\Component;
use Sq\Employee\Models\Attendance;
use Sq\Query\Policy\UserDepartment;

class SetEmployeeAttendanceState extends Component
{
    public $employee, $attendance;
    public $state;
    public function mount($employee): void
    {
        $this->$employee = $employee;
        if (!$employee->today_attendance) {
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
        $this->attendance = [

            // IF enter is null and state not absent
            'present' => is_null($this->employee->today_attendance?->enter) && $this->employee->today_attendance?->state != 'U',

            // IF enter is not Null and State not absent
            'exit' => $this->employee->today_attendance?->enter && is_null($this->employee->today_attendance?->exit) && $this->employee->today_attendance?->state != "U",
            'absent' =>
                !$this->employee->today_attendance?->enter &&
                !$this->employee->today_attendance?->exit &&
                $this->employee->today_attendance?->state != 'U'
        ];
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

        if (in_array($this->employee->orginization?->id, UserDepartment::getUserDepartment())) {

            if ($today_attendance->state != "U" && $state == 'enter') {
                $today_attendance->enter = now();
                $today_attendance->state = "P";
            } elseif ($today_attendance->enter && $today_attendance->state != "U" && $state == 'exit') {
                $today_attendance->exit = now();

            } elseif ($today_attendance->state != "P" && $state == 'upsent') {
                $today_attendance->state = "U";
            }
            $today_attendance->save();
            $this->employee->fresh();
        }
    }
}
