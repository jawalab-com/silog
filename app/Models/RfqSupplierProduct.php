<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqSupplierProduct extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'rfq_detail_id',
        'rfq_supplier_id',
        'product_id',
        'quantity',
        'quantity_verified',
        'unit_id',
        'estimation_price',
        'unit_price',
        'total_estimation_price',
        'total_price',
    ];

    public function rfqDetail()
    {
        return $this->belongsTo(RfqDetail::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
