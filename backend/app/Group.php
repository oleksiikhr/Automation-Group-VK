<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id', 'name', 'description', 'screen_name', 'photo', 'members_count',
        'is_closed', 'deactivated',
    ];

    /**
     * Get the group image.
     *
     * @param string $value
     *
     * @return string
     */
    public function getPhotoAttribute($value)
    {
        $url = env('APP_URL') . '/';

        if ($this->getAttribute('deactivated')) {
            return $url . 'images/static/deactivated_100.png';
        }

        if (empty($value)) {
            return $url . 'images/static/camera_100.png'; // TODO Community image
        }

        return $value;
    }

    /* |----------------------------------------------------------------------------
     * | Relationship
     * |----------------------------------------------------------------------------
     * |
     */

    public function tokens()
    {
        return $this->hasMany(GroupToken::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function cron()
    {
        return $this->hasMany(Cron::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
