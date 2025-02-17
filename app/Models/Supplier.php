<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'supplier_name',
        'contact_name',
        'address',
        'phone',
        'email',
        'account_number',
        'tag',
    ];

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag', 'slug');
    }

    // public function getTagsAttribute($value)
    // {
    //     return json_decode($value);
    // }
}
