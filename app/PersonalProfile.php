<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalProfile extends Model
{
    public function set()
    {
        $this->name = request('name') ?? ($this->name ?? null);
        $this->family = request('family') ?? ($this->family ?? null);
        $this->save();
    }
}
