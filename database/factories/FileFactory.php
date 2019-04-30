<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\File;
use Faker\Generator as Faker;

$factory->define(File::class, function (Faker $faker) {
    $fileAble = [
        App\Category::class,
        App\Product::class,
    ];
    $fileAbleType = $faker->randomElement($fileAble);
    $fileAble = factory($fileAbleType)->create();
    return [
        'path' => $this->faker->imageUrl(150, 120, 'business'),
        'size' => $this->faker->numberBetween(100000, 99999999),
        'type' => config('constants.file.type.image'),
        'position' => $this->faker->numberBetween(0, 2),
        'file_able_type' => $fileAbleType,
        'file_able_id' => $fileAble->id
    ];
});
