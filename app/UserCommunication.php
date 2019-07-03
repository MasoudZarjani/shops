<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCommunication extends Model
{
    use SoftDeletes;

    /**
     * Get the communications for the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the city associated with the communication.
     */
    public function city()
    {
        return $this->hasOne(City::class);
    }

    /**
     * Set user communication field in the model
     */
    public function set()
    {
        $this->address = request('address') ?? ($this->address ?? "");
        $this->phone = request('phone') ?? ($this->phone ?? "");
        $this->postal_code = request('postal_code') ?? ($this->postal_code ?? "");
        $this->email = request('email') ?? ($this->email ?? "");
        $this->fax = request('fax') ?? ($this->fax ?? "");
        $this->city_id = request('city_id') ?? ($this->city_id ?? 0);
        $this->type = request('type') ?? ($this->type ?? "");
        return $this->save();
    }
}
