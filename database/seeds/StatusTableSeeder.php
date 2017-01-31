<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            'name' => 'Open'
        ]);

        DB::table('status')->insert([
            'name' => 'Close'
        ]);
    }
}
