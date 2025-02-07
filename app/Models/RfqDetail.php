<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqDetail extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'rfq_id',
        'product_id',
        'rfq_supplier_id',
        'quantity',
        'quantity_verified',
        'unit_id',
        'estimation_price',
        'unit_price',
        'total_estimation_price',
        'total_price',
    ];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function rfqSupplier()
    {
        return $this->belongsTo(RfqSupplier::class);
    }
}
