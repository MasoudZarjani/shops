<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = File::get("database/data/products.json");
        $products = json_decode($products);
        foreach ($products as $product) {
            $productModel = new Product();
            $productModel->status = $product->status;
            $productModel->product_able_type = $product->product_able_type;
            $productModel->product_able_id = $product->product_able_id;
            $productModel->save();
        }
    }
}
