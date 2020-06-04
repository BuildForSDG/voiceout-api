<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sector;
use Faker\Generator as Faker;

$factory->define(Sector::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->randomElement(['Finance', 'Government', 'Science and Technology', 'Agriculture', 'Oil and Gas', 'Security', 'Education', 'Energy', 'Others']),
    ];
});
