<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Buys;
use Faker\Generator as Faker;
use Faker\Provider\Lorem;



$factory->define(Buys::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'description' => Lorem::sentence($nbWords = 5),
        'amount' => rand (10*10, 999*10) / 10,
        'created_at' => now(),
    ];
});
