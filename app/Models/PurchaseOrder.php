<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'supplier_id',
        'user_id',
        'number',
        'subject',
        'order_date',
        'total_amount',
        'status',
        'comment',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function generateNumber(): void
    {
        $no = self::whereYear('order_date', date('Y'))
            ->whereMonth('order_date', date('m'))
            ->count();
        $no++;

        $this->attributes['number'] = implode('/', [$no, 0, 'ADMIN', date('m'), date('Y')]);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseOrderDetails(): HasMany
    {
        return $this->hasMany(PurchaseOrderDetail::class);
    }
}
