<?php

use Illuminate\Database\Seeder;
use App\Cart;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carts = File::get("database/data/carts.json");
        $carts = json_decode($carts);
        foreach ($carts as $cart) {
            $cartModel = new Cart();
            $cartModel->count = $cart->count;
            $cartModel->color_id = $cart->color_id;
            $cartModel->warrantor_id = $cart->warrantor_id;
            $cartModel->product_id = $cart->product_id;
            $cartModel->save();
        }
    }
}
