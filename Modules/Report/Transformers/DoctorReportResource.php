<?php

namespace Modules\Report\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Medical\Entities\Appointment;

class DoctorReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $appointments = $this->appointments;
        $diagnosises  = $appointments?->pluck('diagnosis');
        $invoices     = $diagnosises?->pluck('invoice');

        return [
            'doctor_id'             => $this->id,
            'doctor_name'           => $this->name,
            'clinic_name'           => $this->clinic?->name,
            'appointments_count'    => $appointments?->count(),
            'diagnosises'           => $diagnosises?->count(),
            'total_collected'       => $invoices?->sum('total_amount'),
            'appointments'          => $this->transformAppointments(),
        ];
    }

    protected function transformAppointments()
    {
        return $this->appointments->map(function(Appointment $appointment) {

            return [
                'date'          => $appointment->date,
                'time'          => $appointment->time,
                'vist_type'     => $appointment->vist_type,
                'patient_name'  => $appointment->patient?->name,
                'status'        => $appointment->status,
                'amount_collected' => $appointment->diagnosis?->inoice?->total_amount ?? 0
            ];
        });
    }
}
