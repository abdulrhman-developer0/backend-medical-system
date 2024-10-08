<?php

namespace Modules\Medical\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    protected static function newFactory()
    {
        return \Modules\Medical\Database\factories\ServiceFactory::new();
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
