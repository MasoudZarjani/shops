<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * Get all of the products that are assigned this tag.
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'tag_able');
    }
}
