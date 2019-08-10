<?php

use Illuminate\Database\Seeder;
Use App\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = File::get("database/data/brands.json");
        $brands = json_decode($brands);
        foreach ($brands as $brand) {
            $brandModel = new Brand();
            $brandModel->status = $brand->status;
            $brandModel->save();
        }
    }
}
