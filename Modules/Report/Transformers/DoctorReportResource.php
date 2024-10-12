<?php

namespace Modules\Report\Transformers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Medical\Entities\Appointment;
use Modules\Medical\Transformers\InvoiceResource;

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
            'statsCollected'                 => $this->stats($invoices),
            'appointments'          => $this->transformAppointments(),
        ];
    }

    protected function stats($invoices)
    {
        $n = now();

        $today = $invoices->whereBetween(
            'created_at',
            [
                $n->startOfDay(),
                $n->endOfDay()
            ]
        )->sum('amount');

        $toweek = $invoices->whereBetween(
            'created_at',
            [
                $n->startOfWeek(),
                $n->endOfWeek()
            ]
        )->sum('amount');


        $toMonth = $invoices->whereBetween(
            'created_at',
            [
                $n->startOfMonth(),
                $n->endOfMonth()
            ]
        )->sum('amount');

        $to3month = $invoices->whereBetween(
            'created_at',
            [
                $n->subMonths(3)->startOfMillennium(),
                $n->subMonth()->endOfMonth(),
            ]
        )->sum('amount');

        return [
            'today'     => $toweek,
            'toweek'    => $toweek,
            'month'     => $toMonth,
            'to3month'  => $to3month
        ];
    }

    protected function transformAppointments()
    {
        return $this->appointments->map(function (Appointment $appointment) {

            return [
                'date'          => $appointment->date,
                'time'          => $appointment->time,
                'visit_type'    => $appointment->visit_type,
                'patient_name'  => $appointment->patient?->name,
                'status'        => $appointment->status,
                'amount_collected' => $appointment->dignosis?->invoice?->total_amount ?? 0,
                'invoice'          => $appointment->diagnosis?->invoice? InvoiceResource::make($appointment->diagnosis?->invoice) : null,
                'is_analysis'      => (bool) $appointment->service_id,
                'analysis_name'     => $appointment->analysis?->name

            ];
        });
    }
}
