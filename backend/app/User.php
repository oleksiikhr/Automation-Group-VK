<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id', 'domain', 'first_name', 'last_name', 'photo_100', 'is_muted', 'is_blocked',
    ];

    /* |----------------------------------------------------------------------------
     * | Relationship
     * |----------------------------------------------------------------------------
     * |
     */

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function tokens()
    {
        return $this->hasMany(UserToken::class);
    }
}
