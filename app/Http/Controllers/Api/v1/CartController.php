<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Cart;

class CartController extends Controller
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
            $this->user = User::checkAuthenticate();
        }
    }

    public function add()
    {
        if (!$this->user)
            return response()->json(['status' => false], 203);
        if ($product = Product::getWithUuid()) {
            if (!$cart = Cart::check($product->id, $this->user->id))
                $cart = new Cart();
            if ($cart->set($this->user->id))
                if ($product->baskets()->save($cart))
                    return response()->json(['status' => true]);
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => false], 204);
    }

    public function list()
    {
        if (!$this->user)
            return response()->json(['status' => false], 203);
        if ($cart = Cart::getWithUserId($this->user->id))
            return response()->json(['data' => CartResource::collection($cart), 'sum_price' => 0]);
        return response()->json(['status' => false], 204);
    }

    public function delete()
    {
        if (!$this->user)
            return response()->json(['status' => false], 203);
        if ($cart = Cart::getWithUuid()) {
            $cart->delete();
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false], 204);
    }

    public function setCartList()
    {
        if (!$this->user)
            return response()->json(['status' => false], 203);
    }

    public function getPersonalData()
    {
        if (!$this->user)
            return response()->json(['status' => false], 203);
        if ($cart = Cart::getWithUserId($this->user->id))
            return response()->json([
                'user' => new UserCartResource($this->user),
                'data' => CartResource::collection($cart),
                'meta' => Utility::meta($cart)
            ]);
        return response()->json(['status' => false], 204);
    }
}
