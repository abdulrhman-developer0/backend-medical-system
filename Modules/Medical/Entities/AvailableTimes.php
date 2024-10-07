<?php

namespace Modules\Medical\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AvailableTimes extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'mon',
        'tue',
        'wed',
        'thu',
        'fri',
        'sat',
        'sun',
    ];

    protected $casts = [
        'mon' => 'array',
        'tue' => 'array',
        'wed' => 'array',
        'thu' => 'array',
        'fri' => 'array',
        'sat' => 'array',
        'sun' => 'array',
    ];

    protected $attributes = [
        'mon' => 'NA',
        'tue' => 'NA',
        'wed' => 'NA',
        'thu' => 'NA',
        'fri' => 'NA',
        'sat' => 'NA',
        'sun' => 'NA',
    ];

    protected static function newFactory()
    {
        return \Modules\Medical\Database\factories\AvailableTimesFactory::new();
    }
}
