<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreateUuid;

class Warrantor extends Model
{
    use CreateUuid, SoftDeletes;
    
    /**
     * Get all of the owning warrantor_able models.
     */
    public function warrantor_able()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the prices for the warrantor.
     */
    public function prices()
    {
        return $this->morphToMany(Price::class, 'price_able');
    }

    /**
     * Get the warranty's baskets.
     */
    public function baskets()
    {
        return $this->hasMany(Basket::class);
    }

    /**
     * Scope a query to return uuid from warrantors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    public static function getWithUuid()
    {
        return Warrantor::ofUuid(request('warrantor_uuid'))->first();
    }
}
