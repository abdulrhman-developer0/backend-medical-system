<?php

namespace Modules\Medical\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'service_id',
        'service_name',
        'tax',
        'amount'
    ];

    protected static function newFactory()
    {
        return \Modules\Medical\Database\factories\InvoiceItemFactory::new();
    }
}
