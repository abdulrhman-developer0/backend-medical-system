<?php

namespace Modules\Medical\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'clinic_id'
    ];

    protected static function newFactory()
    {
        return \Modules\Medical\Database\factories\DoctorFactory::new();
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function availableTimes(): HasMany
    {
        return $this->hasMany(AvailableTimes::class);
    }
}
