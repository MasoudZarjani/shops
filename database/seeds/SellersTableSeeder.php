<?php

use Illuminate\Database\Seeder;
Use App\Seller;
class SellersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sellers = File::get("database/data/sellers.json");
        $sellers = json_decode($sellers);
        foreach ($sellers as $seller) {
            $sellerModel = new Seller();
            $sellerModel->status = $seller->status;
            $sellerModel->save();
        }
    }
}
