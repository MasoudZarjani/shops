<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;
use Validator;
use App\Http\Resources\Admin\MessageResource;

class MessageController extends Controller
{
    /**
     * Get user without sorting
     * @return resource user
     */
    public function index()
    {
        $messages = Message::OfType(config('constants.message.type.comment'))->get();
        return MessageResource::collection($messages);
    }

    public function order()
    {
        $describes = Describe::getByOrder();
        return SettingResource::collection($describes);
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
