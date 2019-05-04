<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    /**
     * Get all of the products that are assigned this attribute.
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'attribute_able');
    }

    /**
     * Get the attribute's describe.
     */
    public function describe()
    {
        return $this->morphOne(Describe::class, 'describe_able');
    }

    /**
     * Scope a query to return active from attribute.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $active
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', config('constants.attribute.status.active'));
    }
}
