<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use CreateUuid, SoftDeletes, Notifiable;

    /**
     * Get the user's city.
     */
    public function city()
    {
        return $this->hasOne('App\City', 'id');
    }

    /**
     * Get the user's province.
     */
    public function province()
    {
        return $this->hasOne('App\Province', 'id');
    }

    /**
     * Scope a query to return uuid from users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    /**
     * Scope a query to return api_token from users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $api_token
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeOfApiToken($query, $api_token)
    {
        return $query->where('api_token', $api_token);
    }

    /**
     * Scope a query to return active from users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $active
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfActive($query)
    {
        return $query->where('status', config('constants.user.status.active'));
    }
}
