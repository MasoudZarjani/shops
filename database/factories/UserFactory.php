<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'api_token' => Str::random(150),
        'name' => $faker->firstName,
        'family' => $faker->lastName,
        'tel' => $faker->phoneNumber,
        'city_id' => 153,
        'status' => 1
    ];
});
