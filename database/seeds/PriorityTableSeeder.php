<?php

use Illuminate\Database\Seeder;

class PriorityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priority')->insert([
			'name' => 'low'
		]);

        DB::table('priority')->insert([
			'name' => 'Medium'
		]);

        DB::table('priority')->insert([
			'name' => 'High'
		]);
    }
}
