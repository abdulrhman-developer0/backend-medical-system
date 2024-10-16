<?php

namespace Modules\Medical\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\User\Entities\User;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'clinic_id',
        'specialty_id',
        'user_id',
        'status'
    ];
    protected $attributes = [
        'status'    => 'active',
    ];

    public static $statuses = [
        'active',
        'inactive',
    ];

    protected static function newFactory()
    {
        return \Modules\Medical\Database\factories\DoctorFactory::new();
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function availableTimes(): HasOne
    {
        return $this->hasOne(AvailableTimes::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
