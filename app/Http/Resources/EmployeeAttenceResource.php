<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeAttenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                'id' => $this->id,
                'registare_no' => $this->registare_no,
                'name' => $this->name,
                'last_name' => $this->last_name,
                'father_name' => $this->father_name,
                'grand_father_name' => $this->grand_father_name,
                'date'=>($this->current_gate_attendance?->date) ? verta(optional($this->current_gate_attendance)->date)->format('Y-m-d') : "",
                'enter'=>($this->current_gate_attendance?->enter) ? verta(optional($this->current_gate_attendance)->enter)->format('h:i a') : "",
                'exit'=>($this->current_gate_attendance?->exit) ? verta(optional($this->current_gate_attendance)->exit)->format('h:i a') : "",
                'state'=>$this->current_gate_attendance?->state,
                'stateLabel'=>$this->current_gate_attendance?->state
            ];
    }
}
