<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTokenPermission extends Model
{
    /* |----------------------------------------------------------------------------
     * | Relationship
     * |----------------------------------------------------------------------------
     * |
     */

    public function token()
    {
        return $this->belongsTo(UserToken::class);
    }
}
