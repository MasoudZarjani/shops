<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Category;
use App\Http\Resources\Api\v1\CategoryDetailResource;
use Illuminate\Support\Collection;
use App\Helpers\Utility;
use App\Http\Resources\Api\v1\ProductResource;
use App\Http\Resources\Api\v1\CategoryResource;

class CategoryController extends Controller
{
    public function list()
    {
        $categories = Category::getParentCategory(config('constants.category.type.main'));
        return CategoryResource::collection($categories);
    }

    public function detail()
    {
        $products = new Collection();
        $category = Category::ofUuid(request('category_uuid'))->ofType(config('constants.category.type.main'))->active()->first();

        $products->push($category->products()->active()->get());
        $subCategory = CategoryDetailResource::collection($category->children);

        $products->push(self::check($category));
        return $products;
        $productsFlatten = $products->flatten();
        $productsFilterNull = Utility::filterNullValue($productsFlatten);
        $productsPagination = Utility::paginate_collection($productsFilterNull, 15);
        $productsResource = ProductResource::collection($productsPagination);
        
        return response()->json([
            'sub_categories' => $subCategory,
            'products' => $productsResource,
            'meta' => Utility::meta($productsResource)
        ]);
    }

    public function check($categories)
    {
        $data = [];
        foreach ($categories->children as $category) {
            if ($category->products) {
                if ($category->products()->active()->get())
                    $data[] = [
                        'products' => $category->products()->active()->get(),
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
