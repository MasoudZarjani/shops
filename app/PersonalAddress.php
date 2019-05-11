<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalAddress extends Model
{
    public function set()
    {
        $this->address = request('address') ?? ($this->address ?? null);
        $this->city_id = request('city_id') ?? ($this->city_id ?? null);
        $this->postal_code = request('postal_code') ?? ($this->postal_code ?? null);
        $this->type = request('type') ?? ($this->type ?? config('constants.address.type.home'));
        $this->save();
    }
}
