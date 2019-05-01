<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\File;
use Faker\Generator as Faker;
use App\Product;

$factory->define(File::class, function (Faker $faker) {
    $fileAble = [
        App\Category::class,
        App\Product::class,
    ];
    $fileAbleType = $faker->randomElement($fileAble);
    $count = Product::count();
    $fileAble = Product::find($this->faker->numberBetween(1, $count));
    $position = config('constants.file.position.mainImage');
    if($fileAbleType == 'App\Category')
        $position = config('constants.file.position.category');
    return [
        'path' => $this->faker->imageUrl(150, 120, 'business'),
        'size' => $this->faker->numberBetween(100000, 99999999),
        'type' => config('constants.file.type.image'),
        'position' => $position,
        'file_able_type' => $fileAbleType,
        'file_able_id' => $fileAble->id
    ];
});
