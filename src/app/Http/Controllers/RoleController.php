<?php

namespace YFDev\System\App\Http\Controllers;

use Spatie\Permission\Models\Role;
use YFDev\System\App\Http\Requests\Role\CreateRequest;
use YFDev\System\App\Http\Requests\Role\ListRequest;
use YFDev\System\App\Http\Requests\Role\UpdateRequest;
use YFDev\System\App\Services\Role\RoleService;

class RoleController extends BaseController
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function options()
    {
        return $this->roleService->options();
    }

    public function list(ListRequest $request)
    {
        return $this->roleService->list();
    }

    public function detail(Role $role)
    {
        return $this->roleService->detail($role);
    }

    public function store(CreateRequest $request)
    {
        return $this->roleService->store();
    }

    public function update(Role $role, UpdateRequest $request)
    {
        return $this->roleService->update($role);
    }

    public function destroy(Role $role)
    {
        return $this->roleService->destroy($role);
    }
}
