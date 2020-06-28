<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Report;
use Faker\Generator as Faker;

$factory->define(Report::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->text,
        'institution_name' => $faker->unique()->company,
        'address' => $faker->address,
        'state' => $faker->state,
        'anonymous' => $faker->boolean(50)
    ];
});
