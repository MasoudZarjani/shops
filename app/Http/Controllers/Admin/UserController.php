<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\User;
use App\UserProfile;
use App\Helpers\UploadAdmin;
use App\Http\Resources\Admin\UserDetailResource;
use App\File;

class UserController extends Controller
{
    /**
     * Get user without sorting
     * @return resource user
     */
    public function index()
    {

        $users = User::get();
        return UserResource::collection($users);
    }

    public function order()
    {
        $users = User::getByOrder();
        return UserResource::collection($users);
    }

    public function filter()
    {
        $users = User::getByFilter();
        return UserResource::collection($users);
    }

    public function delete($id)
    {
        return User::ofId($id)->delete();
    }

    public function update()
    {
        $user = User::ofId(request('id'))->first();
        if ($user->profile->set()) {
            $uploadAdmin = new UploadAdmin();
            if ($result = $uploadAdmin->image(request('avatar'), 'avatars'))
            dd($result);
            $user->setAvatar($result, 0, 0, config('constants.file.position.avatar'));
        }
        return $user;
    }

    public function changeState($id)
    {
        $user = User::ofId($id)->first();
        if ($user->status == 1)
            $status = 0;
        else {
            $status = 1;
        }
        $user->update([
            'status' => $status
        ]);

        return $user;
    }

    public function detail($id)
    {
        return new UserDetailResource(User::ofId($id)->first());
    }
}
