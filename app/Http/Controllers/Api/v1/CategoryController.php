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
        $category = Category::ofUuid(request('uuid'))->ofType(config('constants.category.type.main'))->active()->first();
        $subCategory = CategoryDetailResource::collection($category->children);
        $products = new Collection();
        $products->push(self::check($category));
        $productsFlatten = $products->flatten();
        $productsFilterNull = Utility::filterNullValue($productsFlatten);
        $productsPagination = Utility::paginate_collection($productsFilterNull, 15);
        $productsResource = ProductResource::collection($productsPagination);
        return response()->json([
            'sub_categories' => $subCategory,
            'products' => $productsResource
        ]);
    }

    public function check($categories)
    {
        $data = [];
        foreach ($categories->children as $category) {
            if ($category->product) {
                if ($category->product->status == 1)
                    $data[] = [
                        'product' => $category->product,
                        'children' => self::check($category),
                    ];
                $data[] = [
                    'children' => self::check($category),
                ];
            }
        }
        return $data;
    }
}
