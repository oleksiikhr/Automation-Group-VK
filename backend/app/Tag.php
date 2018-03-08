<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'group_id', 'name', 'hash',
	];

    /* |----------------------------------------------------------------------------
     * | Relationship
     * |----------------------------------------------------------------------------
     * |
     */

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
