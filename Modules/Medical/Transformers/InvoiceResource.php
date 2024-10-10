<?php

namespace Modules\Medical\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $appointment = $this->diagnosis->appointment;
        $patient = $appointment->patient;
        $doctor  = $appointment->doctor;

        return [
            'id'            => $this->id,
            'patinet_name'  => $patient->name,
            'nationality'    => $patient->nationality,
            'national_id'   => $patient->national_id,
            'age'           => $patient->age,
            'hijri_date_of_birth' => $patient->date_of_birth,
            'gregorian_date_of_birth' => now()->subYears($patient->age),
            'mobile'        => $patient->mobile,
            'address'       => $patient->address,
            'visit_type'     => $appointment->visit_type,
            'doctor_name'   => $doctor->name,
            'clinic_name'   => $doctor->clinic->name,
            'type_of_payment'   => $appointment->type_of_payment,
            'taxes'         => $this->total_taxes,
            'total'         => $this->total_amount,
            'services'      => $this->invoiceItems->map(function ($service) {
                return $service->only(['service_name', 'tax', 'amount']);
            })
        ];
    }
}
