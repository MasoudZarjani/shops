<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\File;
use Faker\Generator as Faker;
use App\Category;

$factory->define(File::class, function (Faker $faker) {
    $fileAble = [
        App\Category::class,
    ];
    $fileAbleType = $faker->randomElement($fileAble);
    $fileAble = Category::all();
    return [
        'path' => $faker->imageUrl(150, 120, 'business'),
        'size' => $faker->numberBetween(1000000, 99999999),
        'file_able_type' => $fileAbleType,
        'file_able_id' => $fileAble->unique()->random()->id,
    ];
});