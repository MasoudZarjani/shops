<?php

use Illuminate\Database\Seeder;
use App\Helpers\Database\Factory;
use App\Group;
use App\Product;
use App\Tag;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TagsTableSeeder::class,
            DescribesTableSeeder::class,
            FilesTableSeeder::class,
        ]);

        $group = Group::find(mt_rand(1, 2));
        $products = Product::all();
        $products->map(function($item) use($group){
            $item->groups()->save($group);
            $tag = Tag::find(mt_rand(1, 50));
            $item->tags()->save($tag);
        });
    }
}
