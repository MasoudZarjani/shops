<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /**
     * Get all of the owning device_able models.
     */
    public function device_able()
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to return device_id from users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $device_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfDeviceId($query, $device_id)
    {
        return $query->where('device_id', $device_id);
    }

    public function set()
    {
        $this->device_id = request('device_id') ?? ($this->device_id ?? null);
        $this->name = request('name') ?? ($this->name ?? null);
        $this->os = request('os') ?? ($this->os ?? null);
        $this->version = request('version') ?? ($this->version ?? null);
        $this->push_token = request('push_token') ?? ($this->push_token ?? null);
        $this->status = config('constants.device.status.active');
        $this->save();
    }
}
