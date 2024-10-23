<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'brand_name',
        'brand_description',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
