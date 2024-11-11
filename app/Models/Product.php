<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'product_name',
        'brand_id',
        'tag',
        'product_description',
        'price',
        'minimum_quantity',
        'verified',
        'unit_id',
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag', 'slug');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }

    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'default_unit_id');
    }

    public function unitConversions()
    {
        return $this->hasMany(ProductUnitConversion::class);
    }
}
