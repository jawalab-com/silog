<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqHistory extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'rfq_id',
        'user_id',
        'status',
        'description',
    ];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
