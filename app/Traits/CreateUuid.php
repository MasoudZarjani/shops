<?php

namespace App\Traits;

use Webpatser\Uuid\Uuid;

trait CreateUuid
{

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Uuid::generate(4)->string;
        });
    }
}
