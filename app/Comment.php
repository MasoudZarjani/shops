<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Get all of the owning comment_able models.
     */
    public function comment_able()
    {
        return $this->morphTo();
    }
}
