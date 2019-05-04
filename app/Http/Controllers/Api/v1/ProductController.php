<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
    public function detail()
    {
        return response()->json(Product::get());
    }
}
