<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\User;
use App\UserCommunication;
use App\UserProfile;
use App\Helpers\Mobile;
use App\Helpers\Utility;

$factory->define(User::class, function (Faker $faker) {
    factory(UserProfile::class)->create();
    factory(UserCommunication::class)->create();
    return [
        'phone' => $faker->phoneNumber,
        'mobile' => $faker->phoneNumber,
        'email' => $faker->email,
        'user_name' => $faker->userName,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'api_token' => Str::random(150),
        'reagent_code' => Utility::ReagentRandomCode(),
        'verification_code' => Mobile::RandomCode(),
        'status' => 1,
        'role' => mt_rand(0,2)
    ];
});
