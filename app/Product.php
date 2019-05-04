<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Database\Factory;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use CreateUuid, SoftDeletes;

    /**
     * Get all of the owning product_able models.
     */
    public function product_able()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the tags for the product.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tag_able');
    }

    /**
     * Get all of the groups for the product.
     */
    public function groups()
    {
        return $this->morphToMany(Group::class, 'group_able');
    }

    /**
     * Get all of the files for the product.
     */
    public function files()
    {
        return $this->morphMany(File::class, 'file_able');
    }

    /**
     * Get the product's describe.
     */
    public function describe()
    {
        return $this->morphOne(Describe::class, 'describe_able');
    }

    /**
     * Scope a query to return active from product.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $active
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', config('constants.product.status.active'));
    }
}
