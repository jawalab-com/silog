<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesOrder extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'customer_id',
        'user_id',
        'order_date',
        'status',
        'total_amount',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    // public function generateNumber(): void
    // {
    //     $no = self::whereYear('order_date', date('Y'))
    //         ->whereMonth('order_date', date('m'))
    //         ->count();
    //     $no++;

    //     $this->attributes['number'] = implode('/', [$no, 0, 'ADMIN', date('m'), date('Y')]);
    // }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // public function salesOrderDetails(): HasMany
    // {
    //     return $this->hasMany(SalesOrderDetail::class);
    // }
}
