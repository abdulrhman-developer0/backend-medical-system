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
            'name'      => $this->name,
            'email'     => $this->user?->email,
            'availableTimes' => $this->availableTimes,
        ];
    }
}
