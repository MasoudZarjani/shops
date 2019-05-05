<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = File::get("database/data/categories.json");
        $categories = json_decode($categories);
        foreach ($categories as $category) {
            $categoryModel = new Category();
            $categoryModel->parent_id = $category->parent_id;
            $categoryModel->sort = $category->sort;
            $categoryModel->type = $category->type;
            $categoryModel->status = $category->status;
            $categoryModel->save();
        }
    }
}
