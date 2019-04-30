<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Describe;
use Faker\Generator as Faker;

$factory->define(Describe::class, function (Faker $faker) {
    $describeAble = [
        App\File::class,
    ];
    $describeAbleType = $faker->randomElement($describeAble);
    $describeAble = factory($describeAbleType)->create();
    return [
        'title' => $faker->unique()->word,
        'description' => $faker->unique()->realText(150),
        'describe_able_type' => $describeAbleType,
        'describe_able_id' => $describeAble->id
    ];
});
