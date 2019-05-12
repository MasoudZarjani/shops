<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    /**
     * Get all of the products that are assigned this color.
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'color_able');
    }
}
