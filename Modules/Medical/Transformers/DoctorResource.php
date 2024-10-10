<?php

namespace Modules\Medical\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            "clinicId" => $this->clinic_id,
            'clinicName' => $this->clinic?->name,
            'name'       => $this->name,
            'specialty_id' => $this->specialty_id,
            'specialty_name' => $this->specialty->name,
            'examination_cost' => $this->specialty->examination_cost,
            'email'     => $this->user?->email,
            'status'    => $this->status,
            'availableTimes' => $this->availableTimes,
        ];
    }
}
