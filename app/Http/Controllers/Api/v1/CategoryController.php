<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Category;
use App\Http\Resources\Api\v1\CategoryDetailResource;
use Illuminate\Support\Collection;
use App\Helpers\Utility;
use App\Http\Resources\Api\v1\ProductResource;

class CategoryController extends Controller
{
    public function list()
    {
        return response()->json(Category::getParentCategory(config('constants.category.type.main')));
    }

    public function detail()
    {
        $category = Category::ofUuid(request('uuid'))->active();
        $subCategory = CategoryDetailResource::collection($category->first()->children);
        $product = new Collection();
        $product->push(self::check($category->get()));
        $products = Utility::filterNullValue($product->flatten());
        $products = ProductResource::collection(Utility::paginate_collection($products, 15));
        return response()->json([
            'sub_categories' => $subCategory,
            'products' => $products
        ]);
    }

    public function check($categories)
    {
        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                'product' => $category->product,
                'children' => self::check($category->children),
            ];
        }
        return $data;
    }
}
