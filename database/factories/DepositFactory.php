<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Models\Deposits;
use Faker\Generator as Faker;
use Faker\Provider\Lorem;
use Illuminate\Support\Str;

$factory->define(Deposits::class, function (Faker $faker) {
    return [
        'user_id' => 2,
        'authorized_by' => null,
        'description' => Lorem::sentence($nbWords = 2),
        'authorized' => null,
        'type' => 'income',
        'amount' => rand (10*10, 999*10) / 10,
        'checkbook_image' => storage_path("/images/users/migration-image-check.jpeg"),
        'created_at' => now(),
    ];
});
