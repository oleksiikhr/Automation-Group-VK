<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
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
