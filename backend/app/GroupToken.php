<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupToken extends Model
{
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
