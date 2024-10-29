<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = ['id', 'product_id', 'user_id', 'transaction_type', 'reference_id', 'quantity_change', 'transaction_date', 'note'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'reference_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
