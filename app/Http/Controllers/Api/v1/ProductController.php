<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Product;
use App\Http\Resources\Api\v1\ProductDetailResource;
use App\Http\Resources\Api\v1\SpecificationResource;

class ProductController extends Controller
{
    public function detail()
    {
        $productDetail = new ProductDetailResource(Product::get() ?? []);
        return response()->json($productDetail);
    }

    public function Specification()
    {
        $productDetail = new SpecificationResource(Product::get() ?? []);
        return response()->json($productDetail);
    }
}
