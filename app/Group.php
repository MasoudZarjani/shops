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

    /**
     * Scope a query to return parent from group.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $parent
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfGroupId($query, $groupId)
    {
        return $query->where('group_id', $groupId);
    }

    /**
     * Create new group
     */
    public static function set()
    {
        $group = new Group();
        $group->group_id = 0;
        $group->save();
        return $group;
    }
}
