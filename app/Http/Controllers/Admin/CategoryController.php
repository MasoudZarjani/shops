<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\SettingResource;
use App\Category;
use App\Describe;
use CategoriesTableSeeder;
use config;
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

    //============comment

    public function getComments($id)
    {
        $category = Category::find($id);
        $comments = $category->describes()->ofType(6)->get();
        return SettingResource::collection($comments);
    }

    public function createComment()
    {
        $category = Category::find(request("categoryId"));
        $description = new Describe();
        $description->title = request("title");
        $description->type = 6;
        return $category->describes()->save($description);
    }

    public function updateComment()
    {
        $description = Describe::find(request('id'));
        return $description->set();
    }

    public function deleteComment($id)
    {
        return Describe::ofId($id)->delete();
    }
}
