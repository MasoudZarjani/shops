<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    /**
     * Get all of the owning action_able models.
     */
    public function action_able()
    {
        return $this->morphTo();
    }

    /**
     * Get the action's describe.
     */
    public function describe()
    {
        return $this->morphOne(Describe::class, 'describe_able');
    }
}
