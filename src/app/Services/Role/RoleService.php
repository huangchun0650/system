<?php

namespace YFDev\System\App\Services\Role;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use YFDev\System\App\Exceptions\Request\NotAllowDeleteException;
use YFDev\System\App\Http\Transforms\Models\RoleTransform;
use YFDev\System\App\Models\Admin;
use YFDev\System\App\Repositories\Menu\MenuRepositoryInterface;
use YFDev\System\App\Repositories\Role\RoleRepositoryInterface;
use YFDev\System\App\Services\BaseService;

class RoleService extends BaseService
{
    protected $roleRepository;

    protected $menuRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        MenuRepositoryInterface $menuRepository,
    ) {
        $this->roleRepository = $roleRepository;
        $this->menuRepository = $menuRepository;
    }

    /**
     * options
     */
    public function options(): JsonResponse
    {
        $roleOption = $this->roleRepository->getAll(['id', 'name']);

        return RoleTransform::response(compact('roleOption'));
    }

    /**
     * list
     */
    public function list(): JsonResponse
    {
        $roleList = $this->roleRepository->paginate(
            $this->roleRepository->getAll(),
            request()->input('prePage'),
            request()->input('sortBy'),
            request()->input('orderBy')
        );

        return RoleTransform::response(compact('roleList'));
    }

    /**
     * detail
     *
     * @param  Model  $role
     */
    public function detail($role): JsonResponse
    {
        /**
         * 不能使用 $role->permissions 去取得權限
         * 應該使用 getRolePermissions 方法，因為還要加上 super_admin
         */
        $permissions = $this->roleRepository->getRolePermissions($role);
        $menus = $this->menuRepository->getMenuRulesFromPermission($permissions);

        $roleMenus = [
            'id' => $role->id,
            'name' => $role->name,
            'menus' => $this->buildTree($menus->all()),
        ];

        return RoleTransform::response(compact('roleMenus'));
    }

    /**
     * store
     *
     * @throws \Throwable
     */
    public function store(): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $role = $this->roleRepository->createOrUpdateFromArray([
                'name' => request()->input('name'),
                'guard_name' => 'admin',
            ]);

            $role->syncPermissions(request()->input('permissions', []));
            DB::commit();

            return json_response()->success([
                'message' => 'Role Created Successfully',
            ]);
        } catch (\Throwable $e) {
            Log::error('Error store role: '.$e->getMessage().' at '.$e->getFile().':'.$e->getLine());
            DB::rollBack();

            return json_response()->failed($this->errorCode('SYSTEM_ERROR'), $e->getMessage());
        }
    }

    /**
     * update
     *
     * @param  Model  $role
     *
     * @throws \Throwable
     */
    public function update($role): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $role->name = request()->input('name');
            $role->save();

            $role->syncPermissions(request()->input('permissions', []));
            DB::commit();

            return json_response()->success([
                'message' => 'Role Update Successfully',
            ]);
        } catch (\Throwable $e) {
            Log::error('Error update role: '.$e->getMessage().' at '.$e->getFile().':'.$e->getLine());
            DB::rollBack();

            return json_response()->failed($this->errorCode('SYSTEM_ERROR'), $e->getMessage());
        }
    }

    /**
     * destroy
     *
     * @param  Model  $role
     *
     * @throws \Throwable
     */
    public function destroy($role): \Illuminate\Http\JsonResponse
    {
        // 無法刪除 超級使用者
        if ($role->name === config('permission.super_admin')) {
            throw new NotAllowDeleteException('Super admin role cannot be delete.');
        }

        // Can not delete role which is used
        if (Admin::role($role->name)->exists()) {
            throw new NotAllowDeleteException('Cannot be delete your own role');
        }
        $role->delete();

        return json_response()->success([
            'message' => 'Role Delete Successfully',
        ]);
    }
}
