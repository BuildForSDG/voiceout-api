<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vote;
use Faker\Generator as Faker;

$factory->define(Vote::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1,10),
        'report_id' => $faker->numberBetween(1,10),
        'vote' => $faker->boolean(50)
    ];
});
