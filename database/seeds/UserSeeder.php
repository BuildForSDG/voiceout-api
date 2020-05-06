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
    	factory(App\User::class, 5)->create()->each(function($user) {
    		$user->reports()->save(factory(App\Report::class)->make());
    	});
    }
}
