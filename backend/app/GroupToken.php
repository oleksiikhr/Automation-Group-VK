<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupToken extends Model
{
    /**
     * Ecrypt token.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function setTokenAttribute($value)
    {
        $this->attributes['token'] = encrypt($value);
    }

    /**
     * Decrypt token.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function getTokenAttribute($value)
    {
        return decrypt($value);
    }

    /* |----------------------------------------------------------------------------
     * | Relationship
     * |----------------------------------------------------------------------------
     * |
     */

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function permissions()
    {
        return $this->hasMany(GroupTokenPermission::class);
    }

    public function cron()
    {
        return $this->belongsToMany(Cron::class);
    }
}
