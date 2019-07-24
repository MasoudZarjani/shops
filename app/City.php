<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * Get the city for the communication.
     */
    public function communication()
    {
        return $this->hasOne(UserCommunication::class);
    }

    /**
     * Get the province associated with the city.
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
