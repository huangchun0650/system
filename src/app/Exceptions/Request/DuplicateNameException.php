<?php

namespace YFDev\System\App\Exceptions\Request;

use YFDev\System\App\Constants\ErrorCode;

/**
 * 名稱重複
 */
class DuplicateNameException extends CustomValidationException
{
    public function __construct(string $key)
    {
        parent::__construct($key, 'unique', ErrorCode::NAME_DUPLICATE_ERROR);
    }
}
