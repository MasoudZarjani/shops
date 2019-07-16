<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\UserProfile;
use App\Describe;
use Validator;
use App\Http\Resources\Admin\SettingResource;

class SettingController extends Controller
{
    /**
     * Get user without sorting
     * @return resource user
     */
    public function index()
    {
        $describes = Describe::OfType(config('constants.describe.type.setting'))->select('title','description','id')->get();
        return SettingResource::collection($describes);
    }

    public function order()
    {
        $describes = Describe::getByOrder(config('constants.describe.type.setting'));
        return SettingResource::collection($describes);
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
}
