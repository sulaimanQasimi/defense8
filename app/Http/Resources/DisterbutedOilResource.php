<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vehical\OilType;

class DisterbutedOilResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id'=>$this->id,
            'registare_no'=>$this->card_info->registare_no,
            'full_name'=>$this->card_info->full_name,
            'father_name'=>$this->card_info->father_name,
            'oil_type'=>trans(($this->card_info->oil_type == OilType::Diesel) ? "Diesel" : "Petrole"),
            'monthly_rate'=>trans("Liter", ['value' => $this->card_info->monthly_rate]),
            'oil_amount'=>trans("Liter", ['value' => $this->oil_amount]),
            'date'=>verta($this->filled_date)->format('Y/m/d'),
        ];
    }
}
