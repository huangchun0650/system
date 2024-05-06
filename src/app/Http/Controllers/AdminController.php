<?php

namespace YFDev\System\App\Http\Controllers;

use YFDev\System\App\Models\Admin;
use YFDev\System\App\Services\Admin\AdminService;
use YFDev\System\App\Http\Requests\Admin\RegisterRequest;
use YFDev\System\App\Http\Requests\Admin\UpdateRequest;
use YFDev\System\App\Http\Requests\Admin\ListRequest;

class AdminController extends BaseController
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function list(ListRequest $request)
    {
        return $this->adminService->list();
    }

    public function detail(Admin $admin)
    {
        return $this->adminService->detail($admin);
    }

    public function store(RegisterRequest $request)
    {
        return $this->adminService->store();
    }

    public function update(Admin $admin, UpdateRequest $request)
    {
        return $this->adminService->update($admin);
    }

    public function destroy(Admin $admin)
    {
        return $this->adminService->destroy($admin);
    }
}
