<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
    	'description' => $faker->text,
    	'report_id' => $faker->numberBetween(1,10),
    	'user_id' => $faker->numberBetween(14,24),
    ];
});
