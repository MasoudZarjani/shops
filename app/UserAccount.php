<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use SoftDeletes;

    /**
     * Get the account for the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addWallet($price)
    {
        $this->wallet = $this->wallet + $price ?? 0;
        return $this->save();
    }

    public function subWallet($price)
    {
        $this->wallet = $this->wallet - $price ?? 0;
        return $this->save();
    }
}
