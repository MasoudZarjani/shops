<?php

use Illuminate\Database\Seeder;
use App\Price;

class PricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prices = File::get("database/data/prices.json");
        $prices = json_decode($prices);
        foreach ($prices as $price) {
            $priceModel = new Price();
            $priceModel->price = $price->price;
            $priceModel->discount = $price->discount;
            $priceModel->save();
        }
    }
}
