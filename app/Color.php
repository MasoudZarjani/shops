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

    /**
     * Get all of the files that are assigned this color.
     */
    public function files()
    {
        return $this->morphedByMany(File::class, 'color_able');
    }
}
