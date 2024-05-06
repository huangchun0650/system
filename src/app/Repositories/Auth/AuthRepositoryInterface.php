<?php

namespace YFDev\System\App\Repositories\Auth;

interface AuthRepositoryInterface
{
    public function captcha();

    public function login($request);

    public function logout();

    public function refresh();

    public function selfProfileWithPermissions();
}
