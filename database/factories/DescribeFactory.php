<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Describe;
use Faker\Generator as Faker;

$factory->define(Describe::class, function (Faker $faker) {
    $describeAble = [
        App\Category::class,
    ];
    $describeAbleType = $faker->randomElement($describeAble);
    $describeAble = factory($describeAbleType)->create();
    return [
        'title' => $faker->title,
        'describe_able_type' => $describeAbleType,
        'describe_able_id' => $describeAble->id,
    ];
});
