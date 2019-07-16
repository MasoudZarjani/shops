<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Utility;
use App\User;
use App\Helpers\Upload;
use App\PersonalAddress;
use App\Http\Resources\Api\v1\InformationResource;
use App\UserCommunication;

class UserController extends Controller
{
    protected $mobile;
    protected $user;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (request('mobile'))
            $this->mobile = Utility::checkMobile(request('mobile') ?? "");
        if (request('uuid') && request('api_token')) {
            $this->user = User::checkAuthenticate();
        }
    }

    /**
     * Store the mobile for the given user and send sms for the mobile.
     *
     * @param  string $mobile
     * @return json status
     */
    public function storeNumber()
    {
        if (!$this->mobile)
            return response()->json(['status' => false, 'message' => config('constants.server.message.mobileNumberWrong')], 405);
        $ipCheck = Utility::checkIp();
        if ($ipCheck) {
            $user = User::createOrGetWithMobile($this->mobile);
            if (!$user)
                return response()->json(['status' => false, 'message' => config('constants.server.message.blockUser')], 401);
            if ($user->sendVerificationCode())
                return response()->json(['status' => true], 201);
            return response()->json(['status' => false], 502);
        }
        return response()->json(['status' => false, 'message' => config('constants.server.message.limitedIp')], 413);
    }

    /**
     * Check the mobile for the given user.
     *
     * @param  string $mobile
     * @return json status, api_token, uuid
     */
    public function checkCode()
    {
        if (!$this->mobile)
            return response()->json(['status' => false, 'message' => config('constants.server.message.mobileNumberWrong')], 405);
        if ($user = User::createOrGetDeviceWithMobile($this->mobile))
            return $user;
        return response()->json(['status' => false], 401);
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
        if (!$this->user)
            return response()->json(['status' => false], 401);
        return new InformationResource($this->user);
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
        if (!$this->user)
            return response()->json(['status' => false], 401);
        if (request('reagent_code'))
            if (!$this->user->reagentAction())
                return response()->json([
                    'status' => false,
                    'message' => config('constants.server.message.reagentCodeFailed')
                ], 203);
        if (!$profile = $this->user->profile)
            $profile = new UserProfile();
        $profile->set();
        if ($this->user->profile()->save($profile))
            return response()->json(['status' => true]);
        return response()->json(['status' => false]);
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
        if (!$communication = $this->user->communication)
            $communication = new UserCommunication();
        $communication->set();
        if ($this->user->communication()->save($communication))
            return response()->json(['status' => true]);
        return response()->json(['status' => false]);
    }

    public function setAddress()
    {
        if (!$this->user) {
            return response()->json(["status" => false], 203);
        }
        $address = new PersonalAddress();
        $address->set();
        $this->user->addresses()->save($address);
        return response()->json(['status' => true]);
    }
}
