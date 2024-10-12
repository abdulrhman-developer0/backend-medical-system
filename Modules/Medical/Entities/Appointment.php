<?php

namespace Modules\Medical\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'visit_type',
        'date',
        'time',
        'notes',
        'type_of_payment',
        'serivice_id',
    ];

    protected $attributes = [
        'status'        => 'pending',
        'discount'      => 0,
        'visit_type'     => 'analysis',
    ];

    public static $statuses = [
        'pending',
        'canceled',
        'current',
        'left',
        'paid'
    ];

    public static $paymentTypes = [
        'network',
        'cash'
    ];

    public function getVisitTypeArAttribute()
    {
        $types = Setting::find('visitTypes')?->value ?? [];
        $vistType = $this->attributes['visit_type'] ?? null;

        foreach ($types as $type) {
            if ($visitType == $type['nameEn']) return $type['nameAr'];
        }

        return $vistType;
    }

    public function getTypeOfPaymentAttribute($t)
    {
        $types = Setting::find('paymentTypes')?->value ?? [];
        $typeOfPayment = $this->attributes['type_of_payment'] ?? null;

        foreach ($types as $type) {
            if ( $typeOfPayment == $type['nameEn']) return $type['nameAr'];
        }

        return $typeOfPayment ?? 'Not Selected';
    }

    protected static function newFactory()
    {
        return \Modules\Medical\Database\factories\AppointmentFactory::new();
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function diagnosis()
    {
        return $this->hasOne(Diagnosis::class);
    }
}
