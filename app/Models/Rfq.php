<?php

namespace App\Models;

use App\Enums\RfqStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LakM\Comments\Concerns\Commentable;
use LakM\Comments\Contracts\CommentableContract;

class Rfq extends Model implements CommentableContract
{
	use Commentable;
	use HasFactory;
	use HasUuids;

	private $guestMode = false;

	protected $fillable = [
		'user_id',
		'rfq_number',
		'request_date',
		'allocation_date',
		'title',
		'total_amount',
		'verified_1',
		'verified_2',
		'verified_3',
		'verified_4',
		'verified_1_user_id',
		'verified_2_user_id',
		'verified_3_user_id',
		'verified_4_user_id',
		'payment_status',
		'status',
		'comments',
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

	public function geCommentsAttribute($value): array
	{
		return json_decode($value, true) ?? [];
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function verified_1User(): BelongsTo
	{
		return $this->belongsTo(User::class, 'verified_1_user_id');
	}

	public function verified_2User(): BelongsTo
	{
		return $this->belongsTo(User::class, 'verified_1_user_id');
	}

	public function verified_3User(): BelongsTo
	{
		return $this->belongsTo(User::class, 'verified_1_user_id');
	}

	public function verified_4User(): BelongsTo
	{
		return $this->belongsTo(User::class, 'verified_1_user_id');
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
