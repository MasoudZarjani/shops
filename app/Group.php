<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * Get the group's describe.
     */
    public function describe()
    {
        return $this->morphOne('App\Describe', 'describe_able');
    }

    public static function set()
    {
        $group = new Group();
        $group->save();
        return $group;
    }
}
