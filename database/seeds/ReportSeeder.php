<?php

use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\Report::class, 5)->create()->each(function($report) {
    		$report->user()->save(factory(App\User::class)->make());
    		$report->institution()->save(factory(App\institution::class)->make());
    	});
    }
}
