<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\User;
use Illuminate\Http\Request;
use App\UserProfile;

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
        $user->update([
                'status'=>request('status')
                ]);
        $user->profile()->set();
        if($user->avatar())
        {
            //$user->avatar()->update(['path'=>request('avatar')]);
        }
        elseif(request('avatar')!='') {
            //$user->setAvatar(request('avatar'),0,config("constants.file.type.image"),config("constants.file.position.avatar"));
        }
        
        return $user;
    }

    public function create()
    {
        $user = new User();
        $user->set();

        $profile = new UserProfile();
        $profile->set();
        $user->profile()->save($profile);

        $avatar = new File();
        $avatar->set();
        $user->avatar()->save($avatar);

        return $user;

    }

    public function changeState($id)
    {
        $user = User::ofId($id)->first();
        if($user->status == 1)
            $status = 0;
        else {
            $status = 1;
        }
        $user->update([
            'status'=> $status
        ]);

        return $user;
    }
}
