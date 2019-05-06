<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Utility;
use App\User;
use App\Helpers\Upload;
use App\Http\Resources\Api\v1\UserResource;

class UserController extends Controller
{
    protected $tel;
    protected $user;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (request('tel'))
            $this->tel = Utility::checkTel(request('tel') ?? "");
        if (request('uuid') && request('api_token')) {
            $this->user = User::ofUuid(request('uuid') ?? "")->ofApiToken(request('api_token') ?? "")->first();
        }
    }

    /**
     * Store the tel for the given user and send sms for the tel.
     *
     * @param  string $tel
     * @return json status
     */
    public function storeNumber(Request $request)
    {
        $ipCheck = Utility::checkIp($request->ip(), config('constants.activeIp.register.type'));
        if ($ipCheck == true) {
            $user = User::createOrGetWithTel($this->tel);
            if (!$user) {
                return response()->json(['status' => false, 'message' => config('constants.server.message.blockUser')], 401);
            }
            if ($user->sendVerificationCode() == true)
                return response()->json(['status' => true]);
            return response()->json(['status' => false], 500);
        }
        return response()->json(['status' => false, 'message' => config('constants.server.message.limitedIp')], 413);
    }

    /**
     * Check the tel for the given user.
     *
     * @param  string $tel
     * @return json status, api_token, uuid
     */
    public function checkCode()
    {
        $user = User::createOrGetDeviceWithTel($this->tel);
        if ($user) {
            return $user;
        }
        return response()->json(["status" => false], 203);
    }

    /**
     * Upload the image for the given user.
     *
     * @param  string $uuid
     * @param  string $api_token
     * @param  file $image
     * @return json status, path, mime
     */
    public function upload(Request $request)
    {
        if (!$this->user) {
            return response()->json(["status" => false], 203);
        }
        if ($request->hasFile('file')) {
            $upload = new Upload();
            $upload = $upload->File($request, 'avatars');
            if ($upload['status'] == true) {
                $this->user->setAvatar($upload['path'], $upload['size'], config('constants.file.type.image'), config('constants.file.position.avatar'));
            }
            return $upload;
        }
    }

    /**
     * Delete the image for the given user.
     *
     * @param  string $uuid
     * @param  string $api_token
     * @return json status
     */
    public function deleteImage()
    {
        if (!$this->user) {
            return response()->json(["status" => false], 203);
        }
        if (User::deleteAvatar($this->user))
            return response()->json(['status' => true]);
        return response()->json(['status' => false]);
    }

    /**
     * Show the profile for the given user.
     *
     * @param  string $uuid
     * @param  string $api_token
     * @return json
     */
    public function show()
    {
        if (!$this->user) {
            return response()->json(["status" => false], 203);
        }
        return new UserResource($this->user);
    }

    /**
     * Update the profile for the given user.
     *
     * @param  string $uuid
     * @param  string $api_token
     * @param  string $name
     * @param  string $family
     * @return json status
     */
    public function update()
    {
        if (!$this->user) {
            return response()->json(["status" => false], 203);
        }
        $this->user->edit();
        return response()->json(['status' => true]);
    }

    /**
     * Update the profile for the given user.
     *
     * @param  string $uuid
     * @param  string $api_token
     * @param  string $name
     * @param  string $family
     * @return json status
     */
    public function cityChange()
    {
        if (!$this->user) {
            return response()->json(["status" => false], 203);
        }
        $this->user->edit();
        return response()->json(['status' => true]);
    }
}
