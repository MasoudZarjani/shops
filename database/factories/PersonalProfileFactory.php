<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\PersonalProfile;

$factory->define(PersonalProfile::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'family' => $faker->lastName,
        'profile_able_type' => "App\\User",
        'profile_able_id' => 1,
    ];
});
