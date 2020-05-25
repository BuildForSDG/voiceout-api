<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make(Str::random(5)), // password
        'remember_token' => Str::random(10),
    ];
});


$factory->state(User::class, 'voice', function(Faker $faker) {
	return 	[
		'first_name' => null,
		'last_name' => null,
		'role' => 'voice',
		'voice_id' => $faker->unique()->numberBetween(1,5)
	];
});


$factory->state(User::class, 'institution', function(Faker $faker) {
	return 	[
		'first_name' => null,
		'last_name' => null,
		'role' => 'institution',
		'institution_id' => $faker->unique()->numberBetween(1,10)
	];
});