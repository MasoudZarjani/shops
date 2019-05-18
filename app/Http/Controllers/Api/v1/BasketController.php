<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Basket;
use App\Product;
use App\User;
use App\Http\Resources\Api\v1\BasketResource;

class BasketController extends Controller
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
            $this->user = User::getWithRequest();
        }
    }

    public function add()
    {
        if (!$this->user)
            return response()->json(['status' => false], 203);
        if ($product = Product::getWithUuid()) {
            $basket = Basket::add($product->id, $this->user->id);
            if ($basket->set($this->user->id))
                if ($product->baskets()->save($basket))
                    return response()->json(['status' => true]);
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => false], 204);
    }

    public function list()
    {
        if (!$this->user)
            return response()->json(['status' => false], 203);
        if ($basket = Basket::getWithUserId($this->user->id))
            return BasketResource::collection($basket);
        return response()->json(['status' => false], 204);
    }

    public function delete()
    {
        if (!$this->user)
            return response()->json(['status' => false], 203);
        if ($basket = Basket::getWithUuid())
            
            return response()->json(['status' => true]);
        return response()->json(['status' => false], 204);
    }
}
