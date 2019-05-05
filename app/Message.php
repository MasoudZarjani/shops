<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use CreateUuid, SoftDeletes;

    /**
     * Get all of the owning message_able models.
     */
    public function message_able()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the message's actions.
     */
    public function actions()
    {
        return $this->morphMany('App\Action', 'action_able');
    }

    /**
     * Get the message's describe.
     */
    public function describe()
    {
        return $this->morphOne(Describe::class, 'describe_able');
    }

    /**
     * Get message information
     */
    public static function getWithProduct()
    {
        $product = Product::get();
        return $product->messages;
    }
}
