<?php

namespace Modules\Medical\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected static function newFactory()
    {
        return \Modules\Medical\Database\factories\ClinicFactory::new();
    }

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }
}
