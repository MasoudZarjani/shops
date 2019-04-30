<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * Get all of the products that are assigned this group.
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'group_able');
    }
    
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
        $group->group_id = 0;
        $group->save();
        return $group;
    }
}
