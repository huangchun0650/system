<?php

namespace YFDev\System\App\Repositories\Setting;

use Spatie\Permission\Models\Permission;
use YFDev\System\App\Repositories\BaseRepository;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    protected $model = Permission::class;
}
