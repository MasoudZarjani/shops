<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'category_id' => $this->faker->numberBetween(1, 10),
        'sort' => $this->faker->numberBetween(1, 20),
        'status' => config('constants.category.status.active'),
        'type' => config('constants.category.type.main'),
    ];
});
