<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupTokenPermission extends Model
{
    public function token()
    {
        return $this->belongsTo(GroupToken::class);
    }
}
