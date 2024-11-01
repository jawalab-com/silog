<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'tag_name',
        'tag_description',
        'slug',
    ];

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class);
    // }

    public function products()
    {
        return $this->hasMany(Product::class, 'tag', 'slug');
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class, 'tag', 'slug');
    }
}
