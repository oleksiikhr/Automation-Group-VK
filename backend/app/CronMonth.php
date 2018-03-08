<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronMonth extends Model
{
    protected $fillable = [
        'cron_id', 'month_num',
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
