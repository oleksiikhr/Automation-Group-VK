<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'quest', 'poll_type_id',
	];

    /* |----------------------------------------------------------------------------
     * | Relationship
     * |----------------------------------------------------------------------------
     * |
     */

	public function type()
	{
		return $this->belongsTo(PollType::class);
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class);
	}

	public function answers()
	{
		return $this->hasMany(PollAnswer::class);
	}
}
