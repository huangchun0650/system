<?php

namespace YFDev\System\App\Services\Setting;

use Symfony\Component\HttpFoundation\JsonResponse;
use YFDev\System\App\Http\Transforms\Models\PermissionTransform;
use YFDev\System\App\Repositories\Setting\PermissionRepositoryInterface;
use YFDev\System\App\Services\BaseService;

class PermissionService extends BaseService
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * selfPermissions
     */
    public function selfPermissions(): JsonResponse
    {
        $selfPermissions = $this->getAdminPermissions();

        return PermissionTransform::response(compact('selfPermissions'));
    }
}
