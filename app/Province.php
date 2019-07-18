<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    /**
     * Get the city for the city.
     */
    public function city()
    {
        return $this->hasOne(City::class);
    }
}
