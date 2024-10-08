<?php

namespace Modules\Medical\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
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
            'id'                => $this->id,
            'patient_id'        => $this->patient_id,
            'patient_name'      => $this->patient?->name,
            'doctor_id'         => $this->doctor_id,
            'doctor_name'       => $this->doctor?->name,
            'visit_type'        => $this->visit_type,
            'date'              => $this->date,
            'time'              => $this->time,
            'notes'             => $this->notes,
            'diagnsis'          => $this->diagnosis? DiagnosisResource::make($this->diagnosis) : null,
            'status'            => $this->status,
            'canceled_log'      => $this->canceled_log,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
