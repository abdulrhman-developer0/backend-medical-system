<?php

namespace Modules\Medical\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialty extends Model
{
    use HasFactory;

    protected $fillable = ["name","examination_cost"];

    protected static function newFactory()
    {
        return \Modules\Medical\Database\factories\SpecialtyFactory::new();
    }
}
