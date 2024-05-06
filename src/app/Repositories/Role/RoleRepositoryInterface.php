<?php

namespace YFDev\System\App\Repositories\Role;

use YFDev\System\App\Repositories\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function getRolePermissions($role);
}
