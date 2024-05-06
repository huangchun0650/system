<?php

namespace Database\Seeders;

use YFDev\System\App\Models\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleName = config('permission.super_admin');

        // Try to find the role, if not exists then create
        $role = Role::firstOrCreate(
            ['name' => $roleName, 'guard_name' => 'admin'],
            ['name' => $roleName]
        );

        // Try to find the admin, if not exists then create
        $admin = Admin::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'account'  => 'admin',
                'name'     => 'Admin',
                'password' => Hash::make('123456'), // It is safer to use Laravel's Hash facade
            ]
        );

        // Check if the admin already has the role, if not then assign
        if (!$admin->hasRole($roleName)) {
            $admin->assignRole($roleName);
        }
    }
}
