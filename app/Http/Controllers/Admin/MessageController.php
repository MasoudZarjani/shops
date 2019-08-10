<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;
use Validator;
use App\Http\Resources\Admin\CommentResource;
use App\Http\Resources\Admin\DiscussResource;

class MessageController extends Controller
{
    /**
     * Get user without sorting
     * @return resource user
     */
    public function indexComment()
    {
        $messages = Message::OfType(config('constants.message.type.comment'))->get();
        return CommentResource::collection($messages);
    }

    public function orderComment()
    {
        $messages = Message::getByOrder(config('constants.message.type.comment'));
        return CommentResource::collection($messages);
    }

    public function filterComment()
    {
        $messages = Message::getByFilter(config('constants.message.type.comment'));
        return CommentResource::collection($messages);
    }

    public function changeStateComment($id)
    {
        $Message = Message::ofId($id)->first();
        if ($Message->status == 1)
            $status = 0;
        else {
            $status = 1;
        }
        $Message->update([
            'status' => $status
        ]);

        return $Message;
    }


    public function indexDiscuss()
    {
        $messages = Message::OfType(config('constants.message.type.discuss'))->get();
        return DiscussResource::collection($messages);
    }

    public function orderDiscuss()
    {
        $messages = Message::getByOrder(config('constants.message.type.discuss'));
        return DiscussResource::collection($messages);
    }

    public function filterDiscuss()
    {
        $messages = Message::getByFilter(config('constants.message.type.discuss'));
        return DiscussResource::collection($messages);
    }

    public function changeStateDiscuss($id)
    {

        $Message = Message::ofId($id)->first();
       
        if ($Message->status == 1)
            $status = 0;
        else {
            $status = 1;
        }
        $Message->update([
            'status' => $status
        ]);

        return $Message;
    }

    public function updateDiscuss()
    {
        return Message::setUpdate(request('id'));
    }
}
