<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollAnswer extends Model
{
	protected $fillable = [
		'poll_id', 'answer', 'is_correct_answer',
	];

    /* |----------------------------------------------------------------------------
     * | Relationship
     * |----------------------------------------------------------------------------
     * |
     */

	public function poll()
	{
		return $this->belongsTo(Poll::class);
	}
}
