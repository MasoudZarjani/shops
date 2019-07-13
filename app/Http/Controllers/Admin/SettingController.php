<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\UserProfile;
use App\Describe;
use Validator;
class SettingController extends Controller
{
    /**
     * Get user without sorting
     * @return resource user
     */
    public function index()
    {
        return $describes = Describe::OfType(config('constants.describe.type.setting'))->select('title','description','id')->get();
    }

    public function order()
    {
        return $describes = Describe::getByOrder();
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
            ],
            [
                'title.required' => 'پر کردن این فیلد الزامی است',
                'description.required' => 'پر کردن این فیلد الزامی است',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()->all(),
                'keys' => $validator->messages()->keys()
            ], 400);
        }
        $Describe= new Describe();
        return $Describe->setWithType(config("constants.describe.type.setting"));
    }

    public function delete($id)
    {
        return Describe::ofId($id)->delete();
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
            ],
            [
                'title.required' => 'پر کردن این فیلد الزامی است',
                'description.required' => 'پر کردن این فیلد الزامی است',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages()->all(),
                'keys' => $validator->messages()->keys()
            ], 400);
        }
        $describe = Describe::ofId(request('id'))->first();
        return $describe->set();
    }
}
