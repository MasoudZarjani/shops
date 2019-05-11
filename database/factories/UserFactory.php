<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\User;
use App\Helpers\SendSMS;
use App\PersonalProfile;
use App\PersonalAddress;

$factory->define(User::class, function (Faker $faker) {
    factory(PersonalProfile::class)->create();
    factory(PersonalAddress::class)->create();
    return [
        'phone' => $faker->phoneNumber,
        'mobile' => $faker->phoneNumber,
        'api_token' => Str::random(150),
        'verification_code' => SendSMS::RandomCode(),
        'status' => 1
    ];
});
