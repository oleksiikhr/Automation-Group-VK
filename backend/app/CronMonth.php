<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronMonth extends Model
{
    public function cron()
    {
        return $this->belongsTo(Cron::class);
    }
}
