<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use SoftDeletes;

    /**
     * Get the profiles for the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set user profile field in the model
     */
    public function set()
    {
        $this->full_name = request('first_name') . ' ' . request('last_name') ?? ($this->full_name ?? "");
        $this->first_name = request('first_name') ?? ($this->first_name ?? "");
        $this->last_name = request('last_name') ?? ($this->last_name ?? "");
        $this->father_name = request('father_name') ?? ($this->father_name ?? "");
        $this->national_code = request('national_code') ?? ($this->national_code ?? "");
        return $this->save();
    }
}
