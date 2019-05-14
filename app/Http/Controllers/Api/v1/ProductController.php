<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Product;
use App\Http\Resources\Api\v1\ProductDetailResource;
use App\Http\Resources\Api\v1\SpecificationResource;
use App\User;

class ProductController extends Controller
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

    public function detail()
    {
        $productDetail = new ProductDetailResource(Product::getWithUuid() ?? []);
        return response()->json($productDetail);
    }

    public function Specification()
    {
        $productDetail = new SpecificationResource(Product::getWithUuid() ?? []);
        return response()->json($productDetail);
    }

    public function bookmark()
    {
        if (Product::setBookmark($this->user))
            return response()->json(['status' => true]);
        return response()->json(['status' => false]);
    }
}
