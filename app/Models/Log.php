<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_type',
        'message',
        'severity',
        'user_id',
        'ip_address',
        'context',
    ];

    protected $casts = [
        'context' => 'array',
    ];
}
