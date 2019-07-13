<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;
use App\Helpers\Utility;
use App\Helpers\Mobile;

class User extends Authenticatable
{
    use CreateUuid, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the user's files.
     */
    public function files()
    {
        return $this->morphMany(File::class, 'file_able');
    }

    /**
     * Get the device that owns the user.
     */
    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }

    /**
     * Get the communication that owns the user.
     */
    public function communication()
    {
        return $this->hasOne(UserCommunication::class);
    }

    /**
     * Get the profile that owns the user.
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the account that owns the user.
     */
    public function account()
    {
        return $this->hasOne(UserAccount::class);
    }

    /**
     * Get the socials that owns the user.
     */
    public function social()
    {
        return $this->hasOne(UserSocial::class);
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

    public function scopeOfId($query, $id)
    {
        return $query->where('id', $id);
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
     * Scope a query to return reagent_code from users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $reagent_code
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeOfReagentCode($query, $reagent_code)
    {
        return $query->where('reagent_code', $reagent_code);
    }

    /**
     * Scope a query to return active from users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $active
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', config('constants.user.status.active'));
    }

    /**
     * Get user info or create it
     *
     * @param string mobile
     * @return array user
     */
    public static function createOrGetWithMobile($mobile)
    {
        $user = User::firstOrCreate(['mobile' => $mobile]);
        if ($user->status != config('constants.user.status.block'))
            return $user;
        return false;
    }

    /**
     * Send verification code via sms panel
     *
     * @return boolean
     */
    public function sendVerificationCode()
    {
        $this->verification_code = Mobile::RandomCode();
        $this->save();
        return Mobile::sendSMS($this->mobile, $this->verification_code);
    }

    /**
     * Create or find mobile number in user model
     *
     * @param string mobile
     */
    public static function createOrGetDeviceWithMobile($mobile)
    {
        $user = User::firstOrCreate(['mobile' => $mobile]);
        $check = $user->checkMatchVerificationCode();
        if ($check)
            return UserDevice::checkLimited($user);
        return response()->json(['status' => false, 'message' => config('constants.server.message.verificationCode')], 406);
    }

    /**
     * Check verification code from client with verification code in database
     *
     * @param string verification_code
     * @return boolean
     */
    public function checkMatchVerificationCode()
    {
        return ($this->verification_code == request('verification_code')) ? true : false;
    }

    /**
     * Set user field in the model
     *
     * @return array user
     */
    public function set()
    {
        $this->uuid = $this->uuid ?? (Uuid::generate(4)->string ?? null);
        $this->api_token = $this->api_token ?? Str::random(150);
        $this->reagent_code = Utility::ReagentRandomCode() ?? 0;
        $this->role = config('constants.user.role.user');
        $this->status = config('constants.user.status.active');
        return $this->save();
    }

    public static function checkAuthenticate()
    {
        return User::ofUuid(request('uuid'))->ofApiToken(request('api_token'))->first();
    }

    public function checkDevice()
    {
        if ($device = $this->devices()->ofDeviceId(request('device_id'))->first())
            if ($device->status == config('constants.userDevice.status.active'))
                return true;
        return false;
    }

    public function reagentAction()
    {
        if (!$userRevealed = User::ofReagentCode(request('reagent_code'))->active()->first())
            return false;
        if (!$userAddWallet = $userRevealed->account)
            $userAddWallet = new UserAccount();
        if ($addWallet = Describe::ofType(config('constants.describe.type.setting'))
            ->ofTitle('addWalletForReagentCode')
            ->first()
        )
            $addWallet = $addWallet->description;
        else
            $addWallet = config('constants.server.addWalletForReagentCode');
        $userAddWallet->addWallet($addWallet);
        if ($userRevealed->account()->save($userAddWallet))
            return true;
        return false;
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
        if (!$file = $this->files)
            $file = new File();
        $file->set($path, $size, $type, $position);
        return $this->files()->save($file);
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

    public function avatar()
    {
        return $this->files()->ofPosition(config('constants.file.position.avatar'))->first();
    }

    public static function get()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        return User::latest()->paginate($per_page);
    }

    public static function getByFilter()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        $user = User::whit('user_profiles')->where('mobile', 'LIKE', '%' . request('query') . '%')->paginate($per_page);
        return User::where('mobile', 'LIKE', '%' . request('query') . '%')->paginate($per_page);
    }

    public static function getByOrder()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        $direction = request('direction')  ?? 'asc';
        $sortBy = request('sortBy') ?? 'id';
        return User::orderBy($sortBy, $direction)->paginate($per_page);
    }
}
