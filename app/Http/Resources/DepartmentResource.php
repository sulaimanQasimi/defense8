<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            

            'name' => $this->name,           
            'header' => $this->header,
            'phone' => $this->phone,
            'slug' => $this->slug,

        ];
    }
}
