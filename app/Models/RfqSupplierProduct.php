<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqSupplierProduct extends Model
{
    /** @use HasFactory<\Database\Factories\RfqSupplierProductFactory> */
    use HasFactory;
    use HasUuids;

    protected $fillable = [
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

    public function rfqSupplier()
    {
        return $this->belongsTo(RfqSupplier::class);
    }
}
