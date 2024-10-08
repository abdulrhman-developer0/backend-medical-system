<?php

namespace Modules\Medical\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'diagnosis',
        'notes',
        'diagnosis_date',
    ];

    protected static function newFactory()
    {
        return \Modules\Medical\Database\factories\DiagnosisFactory::new();
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
