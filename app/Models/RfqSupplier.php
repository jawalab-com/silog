<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqSupplier extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'rfq_id',
        'tag',
        'supplier_id',
    ];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag', 'slug');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
