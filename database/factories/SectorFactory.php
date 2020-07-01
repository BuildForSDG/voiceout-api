<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sector;
use Faker\Generator as Faker;

$factory->define(Sector::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->randomElement(['Bribery', 'Corruption', 'Irregularities', 'Human Right Violation', 'Gender Based Violence', 'Others']),
    ];
});
