<?php

namespace Modules\Medical\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nationality',
        'mobile',
        'national_id',
        'address',
        'age',
        'date_of_birth',
        'gender',
    ];

    protected static function newFactory()
    {
        return \Modules\Medical\Database\factories\PatientFactory::new();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
