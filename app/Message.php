<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Get all of the owning message_able models.
     */
    public function message_able()
    {
        return $this->morphTo();
    }
}
