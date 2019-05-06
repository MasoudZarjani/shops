<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\User;
use App\Device;

$factory->define(Device::class, function (Faker $faker) {

    return [
        'device_id' => $faker->unique()->randomDigit,
        'name' => 'HUAWEI TIT-AL00',
        'os' => 0,
        'version' => 10,
        'push_token' => $faker->unique()->randomDigit,
        'device_able_type' => 'App\\User',
        'device_able_id' => factory(User::class)->create()
    ];
});
