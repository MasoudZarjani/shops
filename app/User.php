<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Helpers\SendSMS;

class User extends Authenticatable
{
    use CreateUuid, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['phone', 'mobile', 'name', 'family', 'verification_code'];

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
     * Get the user's detail.
     */
    public function devices()
    {
        return $this->morphMany(Device::class, 'device_able');
    }

    /**
     * Get the user's file.
     */
    public function file()
    {
        return $this->morphOne(File::class, 'file_able');
    }

    /**
     * Get the user's addresses.
     */
    public function addresses()
    {
        return $this->morphMany(PersonalAddress::class, 'address_able');
    }

    /**
     * Get the user's contact.
     */
    public function contact()
    {
        return $this->morphOne(PersonalContact::class, 'contact_able');
    }

    /**
     * Get the user's profile.
     */
    public function profile()
    {
        return $this->morphOne(PersonalProfile::class, 'profile_able');
    }

    /**
     * Get the user's messages.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
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

    /**
     * Create random code and send verification code 
     */
    public function sendVerificationCode()
    {
        $this->verification_code = SendSMS::RandomCode();
        $this->save();
        return SendSMS::sendSMS($this->mobile, $this->verification_code);
    }

    /**
     * Get user info or create it
     * 
     * @param string mobile
     * @return json user
     */
    public static function createOrGetWithMobile($mobile)
    {
        $user = User::firstOrCreate(['mobile' => $mobile]);
        if ($user->status != config('constants.user.status.block'))
            return $user;
        return false;
    }

    /**
     * Check verification send code to user with save verification code in user model
     * 
     * @param string verificationCode
     * @return boolean status
     */
    public function checkMatchVerificationCode($verificationCode)
    {
        return ($this->verification_code == $verificationCode) ? true : false;
    }

    /**
     * Get user info or create it with devices information
     * 
     * @param string mobile
     * @return json user information
     */
    public static function createOrGetDeviceWithMobile($mobile)
    {
        $user = User::firstOrCreate(['mobile' => $mobile]);
        $check = $user->checkMatchVerificationCode(request('active_code'));
        if ($check) {
            $devices = $user->devices;
            $count = 0;
            if (count($devices) > 0) {
                foreach ($devices as $device) {
                    if ($device->device_id != request('device_id')) {
                        $count++;
                    } else {
                        $device->set();
                        return $user->checkFirstLogin();
                    }
                }
                if ($count >= config('constants.server.limitedDevice')) {
                    return response()->json([
                        'status' => false,
                        'message' => config('constants.server.message.limitedDevice')
                    ], 413);
                }
            }
            $device = new Device();
            $device->set();
            $user->devices()->save($device);
            $user->set();
            return $user->checkFirstLogin();
        }
        return response()->json(['status' => false, 'message' => config('constants.server.message.verificationCode')], 406);
    }

    /** 
     * Check login status, first login or  active user
     * 
     * @return json user information
     */
    public function checkFirstLogin()
    {
        $status = false;
        if ($this->profile) {
            if ($this->profile->name == null && $this->profile->family == null) {
                $status = true;
            }
        }
        return response()->json([
            'status' => $status,
            'api_token' => $this->api_token,
            'uuid' => $this->uuid,
        ]);
    }

    /**
     * Set user information
     * @param string uuid
     * @param string api_token
     * @param string reagent_code
     */
    public function set()
    {
        $this->api_token = $this->api_token ?? Str::random(150);
        $this->save();
    }

    /**
     * Edit user information
     * @param string name
     * @param string family
     * @param integer city_id
     * @param integer status
     */
    public function edit()
    {
        $this->setProfile();
        $this->phone = request('phone') ?? ($this->phone ?? null);
        $this->email = request('email') ?? ($this->email ?? null);
        $this->status = config('constants.user.status.active') ?? 0;
        $this->save();
    }

    /**
     * Set contact from this user in the model
     * 
     */
    public function setProfile()
    {
        if (!$this->profile) {
            $profile = new PersonalProfile();
        } else {
            $profile = $this->profile;
        }
        $profile->set();
        $this->profile()->save($profile);
        return $profile;
    }

    /**
     * Set avatar from this user in the model
     * 
     * @param string path
     * @param integer mime
     * @param integer type
     */
    public function setAvatar($path, $size, $type, $position)
    {
        if (!$this->file) {
            $file = new File();
        } else {
            $file = $this->file;
        }
        $file->set($path, $size, $type, $position);
        $this->file()->save($file);
        return $file;
    }

    public static function deleteAvatar($user)
    {
        if ($user->file) {
            $old_path = $user->file->path;
            $user->file->delete();
            if (file_exists($old_path)) {
                @unlink($old_path);
            }
            return true;
        }
        return false;
    }

    public static function getWithRequest()
    {
        return User::ofUuid(request('uuid') ?? "")->ofApiToken(request('api_token') ?? "")->first();
    }
}
