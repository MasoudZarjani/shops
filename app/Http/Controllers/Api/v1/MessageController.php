<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Message;
use App\Http\Resources\Api\v1\MessageResource;

class MessageController extends Controller
{
    public function list()
    {
        if (request('type') == config('constants.message.type.comment'))
            return MessageResource::collection(Message::getWithProduct());
    }
}
