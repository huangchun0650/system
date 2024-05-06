<?php

namespace YFDev\System\App\Exceptions\Auth;

class SessionExpiredException extends AuthorizationException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }
}
