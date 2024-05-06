<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['name' => '全管理', 'guard_name' => 'admin']);
        Role::firstOrCreate(['name' => '全檢視', 'guard_name' => 'admin']);
    }
}
