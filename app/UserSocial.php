<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSocial extends Model
{
    use SoftDeletes;
    
    /**
     * Get the socials for the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set user social field in the model
     */
    public function set()
    {
        $this->telegram = request('telegram') ?? ($this->telegram ?? "");
        $this->instagram = request('instagram') ?? ($this->instagram ?? "");
        $this->twitter = request('twitter') ?? ($this->twitter ?? "");
        $this->facebook = request('facebook') ?? ($this->facebook ?? "");
        return $this->save();
    }
}
