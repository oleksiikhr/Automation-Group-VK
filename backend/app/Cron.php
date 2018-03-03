<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cron extends Model
{
    protected $table = 'cron';

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function days()
    {
        return $this->hasMany(CronDay::class);
    }

    public function months()
    {
        return $this->hasMany(CronMonth::class);
    }

    public function groupTokens()
    {
        return $this->belongsToMany(CronGroupToken::class);
    }

    public function userTokens()
    {
        return $this->belongsToMany(CronUserToken::class);
    }
}
