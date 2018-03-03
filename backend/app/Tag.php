<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'hash',
	];

    public function pollTypes()
    {
        return $this->belongsToMany(PollType::class);
    }

	public function polls()
	{
		return $this->belongsToMany(Poll::class);
	}

	public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
