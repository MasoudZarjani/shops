<?php

use Illuminate\Database\Seeder;
use App\Group;
use App\Product;
use App\Tag;
use App\Price;
use App\Warrantor;

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
            ProductsTableSeeder::class,
            CategoriesTableSeeder::class,
            GroupsTableSeeder::class,
            AttributesTableSeeder::class,
            ProvincesTableSeeder::class,
            ActionsTableSeeder::class,
            MessagesTableSeeder::class,
            DevicesTableSeeder::class,
            PricesTableSeeder::class,
            CitiesTableSeeder::class,
            WarrantorsTableSeeder::class,
            ColorsTableSeeder::class,
            BasketsTableSeeder::class,
        ]);
        $group = Group::find(2);
        $products = Product::all();
        $products->map(function ($item) use ($group) {
            $price = Price::find($item->id);
            $item->prices()->save($price);
            
            $item->groups()->save($group);

            $tag = Tag::find(mt_rand(1, 17));
            $item->tags()->save($tag);
        });
        
        $warrantors = Warrantor::all();
        $warrantors->map(function ($item) {
            $price = Price::find($item->id);
            $item->prices()->save($price);
        });
    }
}
