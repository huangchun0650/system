<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            foreach (config('permission-all') as $guardName => $permissions) {
                foreach ($permissions as $permission => $description) {

                    $permission = Permission::firstOrCreate([
                        'name'       => $permission,
                        'guard_name' => $guardName,
                    ]);

                    $permission->assignRole('全管理');

                    if (strpos($permission->name, 'read') > 0) {
                        $permission->assignRole('全檢視');
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
        }
    }
}
