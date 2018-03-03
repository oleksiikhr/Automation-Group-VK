<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PollType extends Model
{
    use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'quest_is_answer', 'min_count_answers', 'use_count_answers', 'max_count_answers',
		'pattern_answer', 'pattern_correct_answer',
	];

	public function polls()
	{
		return $this->hasMany(Poll::class);
	}

	public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
