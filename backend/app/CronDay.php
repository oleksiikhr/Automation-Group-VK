<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronDay extends Model
{
    public function cron()
    {
        return $this->belongsTo(Cron::class);
    }
}
