<?php

use Illuminate\Database\Seeder;
use App\Basket;

class BasketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baskets = File::get("database/data/baskets.json");
        $baskets = json_decode($baskets);
        foreach ($baskets as $basket) {
            $basketModel = new Basket();
            $basketModel->count = $basket->count;
            $basketModel->color_id = $basket->color_id;
            $basketModel->warrantor_id = $basket->warrantor_id;
            $basketModel->user_id = $basket->user_id;
            $basketModel->basket_able_type = $basket->basket_able_type;
            $basketModel->basket_able_id = $basket->basket_able_id;
            $basketModel->save();
        }
    }
}
