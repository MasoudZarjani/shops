<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'category_id' => $faker->numberBetween(1, 10),
        'sort' => $faker->unique()->numberBetween(1, 70),
    ];
});


