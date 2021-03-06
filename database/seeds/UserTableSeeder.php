<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        		'first_name' => 'Mehmet',
        		'last_name' => 'Uygun',
        		'email' => 'mehmet.uygun@outlook.com',
        		'password' => Hash::make('1234567'),
        	]);
    }
}
