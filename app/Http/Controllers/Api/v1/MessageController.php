<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Message;
use App\Http\Resources\Api\v1\MessageResource;
use App\User;

class MessageController extends Controller
{
    protected $user;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (request('uuid') && request('api_token')) {
            $this->user = User::ofUuid(request('user_uuid') ?? "")->ofApiToken(request('api_token') ?? "")->first();
        }
    }

    public function list()
    {
        $status = false;
        if ($this->user) {
            $status = true;
        }
        if (request('type') == config('constants.message.type.comment'))
            if (Message::getWithProduct())
                return response()->json([
                    'data' => MessageResource::collection(Message::getWithProduct()),
                    'status' => $status
                ]);
        return response()->json('No Content', 204);
    }

    public function create()
    {
        if (!$this->user) {
            return response()->json(["status" => false], 203);
        }
        $message = new Message();
        return $message->set($this->user->id);
    }
}
