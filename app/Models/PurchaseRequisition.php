<?php

namespace App\Models;

use App\Enums\RfqStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseRequisition extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'subject',
        'date_created',
        'date_deadline',
        'state',
        'department',
        'user_id',
    ];

    protected $casts = [
        'status' => RfqStatus::class,
    ];

    public static function generateName(): string
    {
        $no = self::whereYear('date_created', date('Y'))
            ->whereMonth('date_created', date('m'))
            ->count();
        $no++;

        return implode('/', [$no, 0, 'ADMIN', date('m'), date('Y')]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseRequisitionLines(): HasMany
    {
        return $this->hasMany(PurchaseRequisitionLine::class);
    }
}
