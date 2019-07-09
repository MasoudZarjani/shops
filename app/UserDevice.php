<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDevice extends Model
{
    use CreateUuid, SoftDeletes;

    /**
     * Get the devices for the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
        $this->uuid = $this->uuid ?? (Uuid::generate(4)->string ?? null);
        $this->device_id = request('device_id') ?? ($this->device_id ?? null);
        $this->name = request('device_name') ?? ($this->name ?? null);
        $this->os = request('device_os') ?? ($this->os ?? null);
        $this->version = request('device_version') ?? ($this->version ?? null);
        $this->push_token = request('push_token') ?? ($this->push_token ?? null);
        $this->status = config('constants.device.status.active');
        return $this->save();
    }

    /**
     * Check limitations on authorized devices
     *
     * @param array user
     * @return collection user
     */
    public static function checkLimited($user)
    {
        $status = false;
        if (!$device = $user->devices()->ofDeviceId(request('device_id'))->first()) {
            if (!$limitedDevice = (int) strip_tags(Describe::ofType(config('constants.describe.type.setting'))->where(['title' => 'limited_device'])->first()))
                $limitedDevice = config('constants.server.limitedDevice');
            if ($user->devices()->count() >=  $limitedDevice)
                return response()->json([
                    'status' => false,
                    'message' => config('constants.server.message.limitedDevice')
                ], 409);
            $device = new UserDevice();
            $status = true;
        }
        $user->set();
        $device->set();
        $user->devices()->save($device);
        return response()->json([
            'uuid' => $user->uuid,
            'api_token' => $user->api_token,
            'status' => $status
        ]);
    }
}
