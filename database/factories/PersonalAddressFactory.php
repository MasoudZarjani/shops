<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\PersonalAddress;

$factory->define(PersonalAddress::class, function (Faker $faker) {
    return [
        'address' => $faker->address,
        'postal_code' => $faker->postcode,
        'city_id' => 153,
        'address_able_type' => "App\\User",
        'address_able_id' => mt_rand(1, 5),
    ];
});
