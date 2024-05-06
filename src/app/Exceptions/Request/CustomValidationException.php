<?php

namespace YFDev\System\App\Exceptions\Request;

use Exception;
use Throwable;

/**
 * 自定義的驗證例外
 */
abstract class CustomValidationException extends Exception
{
    /**
     * @param  string  $key
     * @param  string  $rule
     * @param  int  $code
     * @param  Throwable|null  $previous
     */
    public function __construct(string $key, string $rule, int $code = 0, ?Throwable $previous = NULL)
    {
        parent::__construct($this->summarize($key, $rule), $code, $previous);
    }

    /**
     * @param  string  $key
     * @param  string  $rule
     * @return string
     */
    protected function summarize(string $key, string $rule): string
    {
        return $key . $rule;
        // return trans("validation.{$rule}", ['attribute' => $key]);
    }
}
