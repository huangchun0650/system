<?php

namespace YFDev\System\App\Exceptions\Request;

use YFDev\System\App\Constants\ErrorCode;
use Exception;

/**
 * 無法修改
 */
class NotAllowUpdateException extends Exception
{
    public function __construct(string $key)
    {
        parent::__construct($key, ErrorCode::INVALID_REQUEST);
    }
}
