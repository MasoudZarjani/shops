<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Category;
use App\Http\Resources\Api\v1\CategoryResource;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function categories()
    {
        return response()->json(Category::getParentCategory(config('constants.category.type.main')));
    }

    public function categoryDetail()
    {
        $category = Category::ofUuid(request('uuid'))->active()->first();
        return $categories = self::recursiveCategory($category->children);
        $subCategory = CategoryResource::collection($categories);
        return [
            'sub_categories' => $subCategory,
        ];
    }

    public static  function recursiveCategory($categories)
    {
        foreach ($categories as $category) {
            if (count($category->children))
                $category['children'] = self::recursiveCategory($category->children);
        }
        return $categories;
    }
}
