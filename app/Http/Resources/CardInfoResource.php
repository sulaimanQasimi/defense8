<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'card_no' => $this->registare_no,
            'name' => $this->full_name,
            'father_name' => $this->father_name,
            'job' => $this->job_structure,
            'card_perform' => verta($this->card_perform)->format('Y/m/d'),
            'card_expired_date' => verta($this->card_expired_date)->format('Y/m/d'),
            'department' => $this->orginization?->fa_name,
            'gun_type' => $this->gun_card?->gun_type,
            'gun_no' => $this->gun_card?->gun_no,
            'employeeOptions' => $this->employeeOptions,
            'remark' => $this->remark,
            'photo' => asset("storage/{$this->photo}"),

        ];
    }

}
