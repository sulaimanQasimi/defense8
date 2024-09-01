<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd();
        return [
            'id' => $this->id,
            'name' => $this->guest?->name,
            'last_name' => $this->guest?->last_name,
            'career' => $this->guest?->career,
            'address' => $this->guest?->address,

            'department' => $this->guest?->host->department->fa_name,
            'head_name' => $this->guest?->host->head_name,
            'job' => $this->guest?->host->job,
            'phone' => $this->guest?->host->phone,
            'hostAddress' => $this->guest?->host->address,
            'registered_at' => verta($this->entered_at)->format("Y/m/d h:i a")
        ];
    }
}
