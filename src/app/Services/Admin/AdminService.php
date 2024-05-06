<?php

namespace YFDev\System\App\Services\Admin;

use YFDev\System\App\Exceptions\Request\NotAllowDeleteException;
use YFDev\System\App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Auth\AuthManager;
use YFDev\System\App\Http\Transforms\Models\AdminTransform;
use YFDev\System\App\Repositories\Admin\AdminRepositoryInterface;

class AdminService extends BaseService
{
    protected $adminRepository;
    protected $auth;

    public function __construct(AdminRepositoryInterface $adminRepository, AuthManager $auth)
    {
        $this->adminRepository = $adminRepository;
        $this->auth = $auth;
    }

    /**
     * list
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $adminList = $this->adminRepository->paginate(
            $this->adminRepository->getAll(),
            request()->input('prePage'),
            request()->input('sortBy'),
            request()->input('orderBy')
        );

        return AdminTransform::response(compact('adminList'));
    }

    /**
     * detail
     *
     * @param Model $admin
     * @return JsonResponse
     */
    public function detail($admin): JsonResponse
    {
        $adminDetail = $admin->load('roles');

        return AdminTransform::response(compact('adminDetail'));
    }

    /**
     * store
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $fields = $this->adminRepository->getConstants('FIELDS');
            $params = $this->transformRequestParameters(request(), $fields);

            $admin = $this->adminRepository->createOrUpdateFromArray($params);

            $admin->assignRole(request()->input('roles', []));

            DB::commit();

            return json_response()->success([
                'message' => 'Admin Created Successfully',
            ]);
        } catch (\Throwable $e) {
            Log::error('Error store admin: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            DB::rollBack();
            return json_response()->failed($this->errorCode('SYSTEM_ERROR'), $e->getMessage());
        }
    }

    /**
     * update
     *
     * @param Model $admin
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update($admin): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();

            $fields = $this->adminRepository->getConstants('FIELDS');
            $params = $this->transformRequestParameters(request(), $fields, ['account']);

            $admin->fill($params);

            $admin->roles()->sync(request()->input('roles', []));

            $admin->save();

            DB::commit();

            return json_response()->success([
                'message' => 'Admin Update Successfully',
            ]);
        } catch (\Throwable $e) {
            Log::error('Error update admin: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            DB::rollBack();
            return json_response()->failed($this->errorCode('SYSTEM_ERROR'), $e->getMessage());
        }
    }

    /**
     * destroy
     *
     * @param Model $admin
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy($admin): \Illuminate\Http\JsonResponse
    {
        $roleNames = $admin->roles->pluck('name')->all();

        // 無法刪除 超級使用者
        if (in_array(config('permission.super_admin'), $roleNames)) {
            throw new NotAllowDeleteException('Can not delete super admin account');
        }

        // 刪除自己
        if ($admin->id === $this->auth->user()->id) {
            throw new NotAllowDeleteException('Can not delete yourself');
        }

        $admin->delete();

        return json_response()->success([
            'message' => 'Admin Delete Successfully',
        ]);
    }
}
