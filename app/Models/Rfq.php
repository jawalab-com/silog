<?php

namespace App\Models;

use App\Enums\RfqStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rfq extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'rfq_number',
        'request_date',
        'total_amount',
        'status',
        'comment',
    ];

    protected $casts = [
        'status' => RfqStatus::class,
    ];

    public function generateNumber(): void
    {
        $no = self::whereYear('request_date', date('Y'))
            ->whereMonth('request_date', date('m'))
            ->count();
        $no++;

        $this->attributes['rfq_number'] = implode('/', [$no, 0, 'ADMIN', date('m'), date('Y')]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rfqDetails(): HasMany
    {
        return $this->hasMany(RfqDetail::class);
    }

    public function rfqSuppliers(): HasMany
    {
        return $this->hasMany(RfqSupplier::class);
    }
}
