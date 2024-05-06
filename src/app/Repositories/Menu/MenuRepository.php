<?php

namespace YFDev\System\App\Repositories\Menu;

use YFDev\System\App\Models\Menu;
use YFDev\System\App\Models\Rule;
use YFDev\System\App\Repositories\BaseRepository;

class MenuRepository extends BaseRepository implements MenuRepositoryInterface
{
    protected $model = Menu::class;

    /**
     * getMenus
     * 取得個人權限選單（包括權限之父層選單）
     */
    public function getMenus(array $selfPermissions)
    {
        $admin = \Auth::user();
        $isSuperAdmin = in_array(config('permission.super_admin'), $admin->roles->pluck('name')->all());

        $menuQuery = Menu::whereHas('permissions', function ($query) use ($selfPermissions) {
            $query->whereIn('name', $selfPermissions);
        });

        if (! $isSuperAdmin) {
            $menuQuery->whereNotIn('code', ['setting', 'testing']);
        }

        $menuIds = $menuQuery->pluck('id')->all();

        // 加入上層 menu ids
        $parentMenuIds = Menu::distinct()->whereNotNull('parent_id')
            ->whereIn('id', $menuIds)
            ->pluck('parent_id')->all();

        $menuIds = array_merge($menuIds, $parentMenuIds);

        return Menu::whereIn('id', $menuIds);
    }

    /**
     * getMenusInPermissions
     * 取得擁有權限選單資料（包括權限之父層選單）
     *
     * @return void
     */
    public function getMenusInPermissions(array $selfPermissions)
    {
        try {
            $menus = $this->getMenus($selfPermissions)->get();

            return $menus->map(function ($menu) use ($selfPermissions) {
                $format = $menu->permissions->map(function ($permission) use ($selfPermissions) {
                    $item[$permission->name] = in_array($permission->name, $selfPermissions);

                    return $item;
                });
                unset($menu['permissions']);
                $menu['permissions'] = $format;

                return $menu;
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * getMenusWithPermissions
     * 取得選單及其權限
     */
    public function getMenusWithPermissions()
    {
        try {
            return Menu::with('permissions')->select(['id', 'name', 'code', 'parent_id'])->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * getMenusWithRules
     * 取得選單及其角色
     */
    public function getMenusWithRules()
    {
        try {
            return Menu::with('rules.methods')->select(['id', 'name', 'code', 'parent_id'])->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * getMenuRulesFromPermission
     *
     * @param  Collection  $permissions
     * @return void
     */
    public function getMenuRulesFromPermission($ownPermissions)
    {
        try {
            $menus = $this->getMenus($ownPermissions->pluck('name')->all())->with(['rules'])->get();
            $ownPermissionIds = $ownPermissions->pluck('id')->all();

            return $menus->map(function ($menu) use ($ownPermissionIds) {
                $menuPermissions = $menu->permissions->pluck('id')->all();
                $permissions = array_intersect($menuPermissions, $ownPermissionIds);
                $rules = $menu->rules->pluck('permissions', 'id')->all();
                $matchRules = $this->getMatchRules($rules, $permissions);

                $rules = $menu->rules->map(function ($rule) use ($matchRules) {
                    return [
                        'id' => $rule->id,
                        'methodName' => $rule->methods->name,
                        'selected' => in_array($rule->id, $matchRules),
                        'permissions' => json_decode($rule->permissions),
                    ];
                });
                unset($menu['rules']);
                $menu->rules = $rules;

                return $menu;
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * menuWithRulesAndPermissionsOptions
     *
     * @param  Collection  $permissions
     */
    public function menuWithRulesAndPermissionsOptions($permissions)
    {
        try {
            $menus = $this->getMenus($permissions->pluck('name')->all())->with(['rules'])->get();

            $menuList = $menus->map(function ($menu) {
                $rules = $menu->rules->map(function ($rule) {
                    return [
                        'id' => $rule->id,
                        'name' => $rule->name,
                        'methodName' => $rule->methods->name,
                        'selected' => false,
                        'permissions' => json_decode($rule->permissions),
                    ];
                });
                unset($menu['rules']);
                $menu->rules = $rules;

                return $menu;
            });

            return $menuList;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * menuWithRulesAndPermissionsOptions
     *
     * @param  Collection  $permissions
     */
    public function permissionGetMenuRoleOption($permissions)
    {
        try {
            $ownPermissionIds = $permissions->pluck('id')->all();
            $menus = $this->getMenus($permissions->pluck('name')->all())->with(['rules'])->get();

            $menuList = $menus->map(function ($menu) use ($ownPermissionIds) {
                $menuPermissions = $menu->permissions->pluck('id')->all();
                $permissions = array_intersect($menuPermissions, $ownPermissionIds);
                $arrayString = '['.implode(', ', $permissions).']';
                $matchRule = Rule::whereRaw('JSON_UNQUOTE(permissions) = ?', [$arrayString])->first();

                $rules = $menu->rules->filter(function ($rule) use ($matchRule) {
                    if ($matchRule->method_id === 1) {
                        return true;
                    } else {
                        return $rule->id === $matchRule->id;
                    }
                })->map(function ($rule) {
                    return [
                        'id' => $rule->id,
                        'name' => $rule->name,
                        'methodName' => $rule->methods->name,
                        'selected' => false,
                        'permissions' => json_decode($rule->permissions),
                    ];
                })->values();

                unset($menu['rules']);
                $menu->rules = $rules;

                return $menu;
            });

            return $menuList;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * menuPermissionsFormat
     * 資料扁平化
     *
     * @param  Collection  $permissions
     */
    protected function menuPermissionsFormat($permissions): array
    {
        $menuPermissions = [];
        foreach ($permissions->pluck('id', 'name')->all() as $key => $value) {
            $segments = explode('.', $key);
            $group = $segments[0];

            if (! isset($menuPermissions[$group])) {
                $menuPermissions[$group] = [];
            }

            $menuPermissions[$group][] = $value;
        }

        return $menuPermissions;
    }

    /**
     * getMatchRules
     * 找出符合權限的規則
     *
     * @param  array  $rules
     * @param  array  $menuPermissions
     */
    protected function getMatchRules($rules, $menuPermissions): array
    {
        $matchingPermissions = [];
        foreach ($rules as $key => $rule) {
            $permissions = json_decode($rule, true);
            if (count(array_diff($permissions, $menuPermissions)) === 0) {
                $matchingPermissions[] = $key;
            }
        }

        if (count($matchingPermissions) === count($rules)) {
            $maxCount = 0;
            $maxElement = null;

            foreach ($rules as $key => $rule) {
                $permissions = json_decode($rule, true);
                $count = count(array_intersect($permissions, $menuPermissions));
                if ($count > $maxCount) {
                    $maxCount = $count;
                    $maxElement = $key;
                }
            }

            $matchingPermissions = [$maxElement];
        }

        return $matchingPermissions;
    }
}
