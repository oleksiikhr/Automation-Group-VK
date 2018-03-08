<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cron extends Model
{
    protected $table = 'cron';

    protected $fillable = [
        'group_id', 'name', 'description', 'frequency', 'start_time', 'end_time', 'command',
        'command_type_id', 'publication_less_at', 'publication_more_at',
    ];

    /* |----------------------------------------------------------------------------
     * | Relationship
     * |----------------------------------------------------------------------------
     * |
     */

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
