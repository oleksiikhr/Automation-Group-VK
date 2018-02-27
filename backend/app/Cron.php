<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cron extends Model
{
    protected $table = 'cron';

    public function days()
    {
        return $this->hasMany(CronDay::class);
    }

    public function months()
    {
        return $this->hasMany(CronMonth::class);
    }
}
