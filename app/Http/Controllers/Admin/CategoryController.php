<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryResource;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Get user without sorting
     * @return resource user
     */
    public function index()
    {
        $parentId = request('id') ?? 0;
        $categories = Category::ofCategoryId($parentId)->get();
        return CategoryResource::collection($categories);
    }

    public function order()
    {
        $categories = Category::getByOrder();
        return CategoryResource::collection($categories);
        //return response()->json(['data' => $data,'currentParentId'=>10]);
    }

    public function filter()
    {
        $categories = Category::getByFilter();
        return CategoryResource::collection($categories);
    }

    public function create()
    {
        return Category::set();
    }

    public function delete($id)
    {
        return Category::ofId($id)->delete();
    }

    public function update()
    {
        return Category::setUpdate(request('id'));
    }

    public function changeState($id)
    {
        $category = Category::ofId($id)->first();
        if ($category->status == 1)
            $status = 0;
        else {
            $status = 1;
        }
        $category->update([
            'status' => $status
        ]);

        return $category;
    }
}
