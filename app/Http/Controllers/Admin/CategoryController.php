<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryResource;
use App\User;
use Illuminate\Http\Request;
use App\UserProfile;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Get user without sorting
     * @return resource user
     */
    public function index()
    {
        $parentId = request('id') ?? "";
        $categories = Category::ofCategoryId($parentId)->get();
        return CategoryResource::collection($categories);
    }

    public function order()
    {
        $categories = Category::getByOrder();
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
    
}
