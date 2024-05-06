<?php

namespace Database\Seeders;

use YFDev\System\App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('menus') as $menuData) {
            // 检查是否存在相同 code 的记录
            if (!Menu::where('code', $menuData['code'])->exists()) {
                $menu = Menu::create([
                    'sort_order' => $menuData['sort_order'],
                    'name'       => $menuData['name'],
                    'code'       => $menuData['code'],
                    'parent_id'  => $menuData['parent_id'],
                ]);

                $permissions = $menuData['permissions'];
                $rules = $menuData['rules'];

                if ($permissions) {
                    $menu->permissions()->attach($permissions);
                }
                if ($rules) {
                    $menu->rules()->attach($rules);
                }
            }
        }
    }
}
