<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronDay extends Model
{
    protected $fillable = [
        'cron_id', 'day_num',
    ];

    /* |----------------------------------------------------------------------------
     * | Relationship
     * |----------------------------------------------------------------------------
     * |
     */

    public function cron()
    {
        return $this->belongsTo(Cron::class);
    }
}
