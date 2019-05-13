<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Message;
use App\Http\Resources\Api\v1\MessageResource;
use App\User;
use App\Product;
use App\Category;
use App\Helpers\Utility;
use App\Action;
use App\Http\Resources\Api\v1\RateResource;

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
            $this->user = User::ofUuid(request('uuid') ?? "")->ofApiToken(request('api_token') ?? "")->first();
        }
    }

    public function list()
    {
        $message = "";
        $product = Product::getWithUuid();
        if ($product)
            $rate = new RateResource($product->actions()->ofType(config('constants.action.type.rate')));
        if ($this->user)
            $message = Message::checkQuestionWithUuid($this->user->id);
        if (request('type') == config('constants.message.type.comment'))
            if ($messages = Message::getWithProduct($product))
                return response()->json([
                    'data' => MessageResource::collection($messages),
                    'meta' => Utility::meta($messages),
                    'message_uuid' => $message,
                    'product_title' => $product->describe->title,
                    'rate' => $rate,
                    'action' => [
                        [
                            'value' => 5,
                            'title' => 'ارزش خرید در برابر قیمت',
                            'count' => 5
                        ],
                        [
                            'value' => 3,
                            'title' => 'کیفیت ساخت"',
                            'count' => 5
                        ],
                        [
                            'value' => 1,
                            'title' => 'کارایی و عملکرد"',
                            'count' => 5
                        ],
                        [
                            'value' => 2,
                            'title' => 'طراحی و ظاهر"',
                            'count' => 5
                        ],
                    ]
                ]);
        return response()->json('No Content', 204);
    }

    public function detail()
    {
        return MessageResource::collection(Message::getWithUuid());
    }

    public function create()
    {
        if ($this->user) {
            $message = new Message();
            //if (!Message::checkQuestion($this->user->id))
                if ($message->set($this->user->id))
                    return response()->json(["status" => true]);
            return response()->json(["status" => false]);
        }
        return response()->json(["status" => false], 203);
    }

    public function question()
    {
        if (!$this->user) {
            return response()->json(["status" => false], 203);
        }

        if ($product = Product::getWithUuid()) {
            $category = $product->product_able;
            return Category::getQuestion($category);
        }
        return response()->json(["status" => false]);
    }

    public function like()
    {
        if (Message::setMessageAction($this->user->id))
            return response()->json(["status" => true]);
        return response()->json(["status" => false]);
    }
}
