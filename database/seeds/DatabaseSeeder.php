<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(PriorityTableSeeder::class);
        $this->call(CreateTicketSeeder::class);
        $this->call(RolePermissionSeeder::class);
    }
}
