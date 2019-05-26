<?php

use Illuminate\Database\Seeder;

class CartAblesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cart_ables')->delete();
        $json = File::get("database/data/cartAbles.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            DB::table('cart_ables')->insert([
                'cart_id' => $obj->cart_id,
                'cart_able_type' => $obj->cart_able_type,
                'cart_able_id' => $obj->cart_able_id,
            ]);
        }
    }
}
