<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'base_price',
        'max_guests',
        'photos',
    ];

    public function getPhotosAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setPhotosAttribute($value)
    {
        $this->attributes['photos'] = json_encode($value);
    }
}
