<?php

namespace YFDev\System\App\Services\Auth;

use Exception;
use Illuminate\Support\Facades\Log;
use YFDev\System\App\Repositories\Auth\AuthRepositoryInterface;
use YFDev\System\App\Repositories\Menu\MenuRepositoryInterface;
use YFDev\System\App\Services\BaseService;

class AuthService extends BaseService
{
    protected $authRepository;

    protected $menuRepository;

    public function __construct(
        AuthRepositoryInterface $authRepository,
        MenuRepositoryInterface $menuRepository,
    ) {
        $this->authRepository = $authRepository;
        $this->menuRepository = $menuRepository;
    }

    /**
     * getCaptcha
     */
    public function getCaptcha(): \Illuminate\Http\JsonResponse
    {
        return json_response()->success(
            $this->authRepository->captcha(),
        );
    }

    /**
     * login
     *
     * @throws \Throwable
     */
    public function login(): \Illuminate\Http\JsonResponse
    {
        try {
            $token = $this->authRepository->login(request());

            if (is_null($token)) {
                throw new Exception('Login Failed, The Account or Password is Incorrect');
            }

            return json_response()->success([
                'token' => $token,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error Login: '.$e->getMessage().' at '.$e->getFile().':'.$e->getLine());

            return json_response()->failed($this->errorCode('SYSTEM_ERROR'), $e->getMessage());
        }
    }

    /**
     * logout
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        $this->authRepository->logout();

        return json_response()->success([
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * refresh
     */
    public function refresh(): \Illuminate\Http\JsonResponse
    {
        return json_response()->success(
            $this->authRepository->refresh(),
        );
    }

    /**
     * profile
     */
    public function profile(): \Illuminate\Http\JsonResponse
    {
        return json_response()->success(
            $this->authRepository->selfProfileWithPermissions(),
        );
    }

    /**
     * menuList
     */
    public function menuList(): \Illuminate\Http\JsonResponse
    {
        $selfPermissions = $this->getAdminPermissions()->pluck('name')->all();

        $menuList = $this->menuRepository->getMenusInPermissions($selfPermissions);

        return json_response()->success(
            $this->buildTree($menuList->all())
        );
    }
}
