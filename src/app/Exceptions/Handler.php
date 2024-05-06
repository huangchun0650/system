<?php

namespace YFDev\System\App\Exceptions;

use YFDev\System\App\Constants\ErrorCode;
use YFDev\System\App\Exceptions\Auth\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use YFDev\System\App\Exceptions\Request\CustomValidationException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Auth\Access\AuthorizationException as PermissionException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        CustomValidationException::class,
        ValidationException::class,
        ModelNotFoundException::class,
        AuthorizationException::class,
        PermissionException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $e
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $e)
    {
        parent::report($e);

        if ($this->shouldReport($e)) {
            // tg notify
            // telegram_notify()->error(
            //     "Message：\n{$e->getMessage()}".PHP_EOL.
            //     "File：{$e->getFile()}"
            // );
            //log
            \Log::error(
                "Message：\n{$e->getMessage()}".PHP_EOL.
                "File：{$e->getFile()}"
            );
        }
    }

    /**
     * @return array
     */
    protected function context(): array
    {
        $url = \Request::url();
        $method = \Request::method();
        $id = \Auth::id();
        $account = \Auth::user()?->account;

        return array_filter(
            compact('url', 'method', 'id', 'account')
        );
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e->getCode() === ErrorCode::INVALID_REQUEST) {
            return json_response()->failed($e->getCode(), $e->getMessage());
        }

        /** 請求參數驗證不符合 (額外定義) */
        if ($e instanceof CustomValidationException) {
            return json_response()->failedValidation($e->getCode(), $e->getMessage());
        }

        /** 請求參數驗證不符合 */
        if ($e instanceof ValidationException || $e instanceof ModelNotFoundException) {
            return json_response()->failedValidation(ErrorCode::PARAMETERS_ERROR, $e->getMessage());
        }

        /** 未授權的例外 */
        if ($e instanceof AuthorizationException || $e instanceof AuthenticationException) {
            return json_response()->unauthorized(ErrorCode::JWT_INVALID, $e->getMessage());
        }

        /** 連線錯誤 */
        if ($e instanceof GuzzleException) {
            return json_response()->failed(ErrorCode::GUZZLE_ERROR, $e->getMessage());
        }

        /** 權限不足 */
        if ($e instanceof PermissionException) {
            return json_response()->failedPermissionDefined($e->getMessage());
        }

        /** 未定義的錯誤 */
        return json_response()->failedAbnormalOperation($e->getMessage());
    }
}
