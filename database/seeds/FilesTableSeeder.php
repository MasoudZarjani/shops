<?php

use Illuminate\Database\Seeder;
use App\File;
use Faker\Factory as Faker;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        factory(File::class, 30)->create();
        factory(File::class, 3)->create()->each(function ($item) use ($faker) {
            $item->path = $faker->imageUrl(150, 120, 'business');
            $item->size = $faker->numberBetween(1000000, 99999999);
            $item->type = config('constants.file.type.image');
            $item->position = config('constants.file.position.mainSlider');
            $item->save();
        });
    }
}
