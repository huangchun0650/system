<?php

namespace YFDev\System\App\Http\Requests\Auth;

use YFDev\System\App\Exceptions\Request\CaptchaException;
use YFDev\System\App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function authorize()
    {
        if (\Auth::check()) {
            \Auth::logout();
        }

        return true;
    }

    public function base()
    {
        return [
            'account' => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (! config('app.setCaptcha')) {
            return $this->base();
        }

        $captchaData = \Cache::get($this->cache_key);

        return [
            'account' => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha_api:'.\Arr::get($captchaData, 'captcha').', flat',
        ];
    }

    public function messages()
    {
        return [
            'captcha.captcha_api' => CaptchaException::class,
        ];
    }
}
