<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permissions()
    {
        return $this->hasMany(UserTokenPermission::class);
    }

    public function cron()
    {
        return $this->belongsToMany(Cron::class);
    }
}
