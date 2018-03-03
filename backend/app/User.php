<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'address', 'first_name', 'last_name', 'image', 'is_blocked',
    ];

    public function polls()
    {
    	return $this->hasMany(Poll::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function tokens()
    {
        return $this->hasMany(UserToken::class);
    }
}
