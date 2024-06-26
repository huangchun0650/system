<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SuperAdminSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(MethodSeeder::class);
        $this->call(RuleSeeder::class);
        $this->call(MenuSeeder::class);
    }
}
