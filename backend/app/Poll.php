<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'quest', 'user_id', 'type_id',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function type()
	{
		return $this->belongsTo(PollType::class);
	}

	public function tag()
	{
		return $this->belongsTo(Tag::class);
	}

	public function answers()
	{
		return $this->hasMany(PollAnswer::class);
	}
}
