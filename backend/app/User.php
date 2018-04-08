<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id', 'domain', 'first_name', 'last_name', 'photo', 'is_muted', 'is_blocked',
    ];

    /**
     * Get the user's image.
     *
     * @param string $value
     *
     * @return string
     */
    public function getPhotoAttribute($value)
    {
        $url = env('APP_URL') . '/';

        if ($this->getAttribute('is_blocked')) {
            return $url . 'images/static/deactivated_100.png';
        }

        if (empty($value)) {
            return $url . 'images/static/camera_100.png';
        }

        return $value;
    }

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
