<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\User::class, 10)->create()->each(function($user) {
    		$user->reports()->save(factory(App\Report::class)->make());
    	});

        factory(\App\User::class, 5)->states('voice')->create();

        factory(\App\User::class, 2)->states('institution')->create();

    }
}

