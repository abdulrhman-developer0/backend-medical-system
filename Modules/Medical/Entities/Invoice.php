<?php

namespace Modules\Medical\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagnosis_id',
        'total_taxes',
        'discount',
        'total_amount'
    ];

    protected static function newFactory()
    {
        return \Modules\Medical\Database\factories\InvoiceFactory::new();
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
