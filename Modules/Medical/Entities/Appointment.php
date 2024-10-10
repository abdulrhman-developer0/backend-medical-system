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
    ];

    protected $attributes = [
        'status' => 'pending',
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

        foreach ($types as $type) {
            if ($this->visit_type == $type['nameEn']) return $type['nameAr'];
        }

        return 'none';
    }

    public function getTypeOfPaymentAttribute()
    {
        $types = Setting::find('paymentTypes')?->value ?? [];

        foreach ($types as $type) {
            if ($this->type_of_payment == $type['nameEn']) return $type['nameAr'];
        }

        return 'none';
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
