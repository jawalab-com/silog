<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfqComment extends Model
{
	protected $fillable = [
		'user_id',
		'rfq_id',
		'comment',
		'role',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
