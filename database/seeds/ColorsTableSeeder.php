<?php

use Illuminate\Database\Seeder;
use App\Color;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = File::get("database/data/colors.json");
        $colors = json_decode($colors);
        foreach ($colors as $color) {
            $colorModel = new Color();
            $colorModel->code = $color->code;
            $colorModel->name = $color->name;
            $colorModel->save();
        }
    }
}
