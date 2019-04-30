<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'status' => config('constants.category.status.active'),
        'type' => config('constants.category.type.main'),
    ];
});
