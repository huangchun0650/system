<?php

namespace YFDev\System\App\Repositories\Auth;

use Illuminate\Auth\AuthManager;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Mews\Captcha\Captcha;
use YFDev\System\App\Repositories\BaseRepository;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    protected $captcha;

    protected $auth;

    public function __construct(Captcha $captcha, AuthManager $auth)
    {
        $this->captcha = $captcha;
        $this->auth = $auth;
    }

    /**
     * captcha
     * 取得登入數字驗證碼 ＆ 圖片
     *
     * cache_key 快取key
     * expired_at 快取key 到期時限
     * captcha_img 驗證碼 base64 Image
     *
     * @return void
     */
    public function captcha()
    {
        $key = 'cacheKey-'.Str::random(15);
        $captcha_mode = 'flat';
        $captcha = $this->captcha->create($captcha_mode, true);
        $expiredAt = now()->addSeconds(config("captcha.{$captcha_mode}.expire", 120));

        Cache::put($key, [
            'captcha' => $captcha['key'],
        ], $expiredAt);

        return [
            'cache_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_img' => $captcha['img'],
        ];
    }

    /**
     * login
     * 驗證登入
     *
     * $request->account  帳號
     * $request->password 密碼
     *
     * @param [type] $request
     * @return void
     */
    public function login($request)
    {
        $credentials = $request->only('account', 'password');
        if (! $this->auth->attempt($credentials)) {
            return null;
        }

        return auth()->login($this->auth->user());
    }

    /**
     * logout
     * 登出
     */
    public function logout()
    {
        return $this->auth->logout();
    }

    /**
     * refresh
     * Token 刷新機制
     */
    // TODO middleware or event 監聽 token 快到期後 socket 通知前端進行刷新
    public function refresh()
    {
        return [
            'admin' => $this->auth->user()->name,
            'token' => $this->auth->refresh(),
        ];
    }

    /**
     * selfProfileWithPermissions
     * 取得使用者個人角色權限資料
     *
     * @return void
     */
    public function selfProfileWithPermissions()
    {
        $user = $this->auth->user();

        return [
            'account' => $user->account,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles,
        ];
    }
}
