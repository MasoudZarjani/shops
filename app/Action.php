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

    /**
     * Create action
     */
    public function set($user_id)
    {
        $this->value = request('value') ?? "";
        $this->user_id = $user_id ?? 0;
        $this->describe_id = request('describe_uuid') ?? 0;
        $this->type = request('action_type') ?? 0;
        $this->status = config('constants.action.type.question');
        $this->save();
        return $this;
    }
}
