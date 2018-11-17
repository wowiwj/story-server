<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\SmsLog::class, function (Faker $faker) {
    return [
        'phone' => '13888888888',
        'code' => 1234,
        'type' => 'register'
    ];
});
