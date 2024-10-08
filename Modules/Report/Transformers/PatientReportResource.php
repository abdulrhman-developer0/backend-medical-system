<?php

namespace Modules\Report\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientReportResource extends JsonResource
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
            'patient_id'            => $this->id,
            'patient_name'          => $this->name,
            'nationality'           => $this->nationality,
            'age'                   => $this->age,
            'gender'                => $this->gender,
            'appointments'          => $this->appointments->map(function ($appointment) {
                return [
                    'doctor_name'   => $appointment->doctor->name,
                    'date'          => $appointment->date,
                    'time'          => $appointment->time,
                    'vist_type'     => $appointment->visit_type,
                    'status'        => $appointment->status,
                    'canceled_log'  => $this->canceled_log,
                ];
            })
        ];
    }
}
