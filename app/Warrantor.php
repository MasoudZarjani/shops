<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warrantor extends Model
{
    /**
     * Get all of the owning warrantor_able models.
     */
    public function warrantor_able()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the prices for the warrantor.
     */
    public function prices()
    {
        return $this->morphToMany(Price::class, 'price_able');
    }
}
