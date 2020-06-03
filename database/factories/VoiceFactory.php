<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Voice;
use Faker\Generator as Faker;

$factory->define(Voice::class, function (Faker $faker) {
    return [
    	'name' => $faker->unique()->company,
    	'address' => $faker->address,
    	'email' => $faker->email,
    ];
});
