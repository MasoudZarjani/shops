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
        $describes = Describe::getByOrder();
        return SettingResource::collection($describes);
    }

    public function update()
    {
        $describe = Describe::ofId(request('id'))->first();
        return $describe->set();
    }    
}
