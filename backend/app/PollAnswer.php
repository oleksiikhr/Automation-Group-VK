<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollAnswer extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'poll_id', 'answer', 'is_correct_answer',
	];

	public function poll()
	{
		return $this->belongsTo(Poll::class);
	}
}
