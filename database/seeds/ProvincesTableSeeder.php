<?php

use Illuminate\Database\Seeder;
use App\Province;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->delete();
        $json = File::get("database/data/provinces.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Province::create(array(
                'name' => $obj->name,
            ));
        }
    }
}
