<?php

namespace YFDev\System\App\Exceptions\Payment;

use Exception;

class RtnException extends Exception
{
    public function __construct($code)
    {
        $message = $this->toRtnMessage($code);
        parent::__construct($message, $code);
    }

    /**
     * 轉換為回應訊息
     *
     * @param  int $code
     * @return string
     */
    public function toRtnMessage($code)
    {
        $messageList = [
            102 => 'Generate CheckMacValue failed',
            103 => 'Response is not JSON format',
            104 => 'Class with hash do not exist',
            105 => 'Get response failed',
            106 => 'CheckMacValue verify failed',
            107 => 'cURL initialize failed',
            108 => 'Perform cURL session failed',
            109 => 'AES decrypt failed',
            110 => 'AES encrypt failed',
            111 => 'JSON decrypt failed',
        ];
        $message = 'Undefined error';
        if (isset($messageList[$code])) {
            $message = $messageList[$code];
        }

        return $message;
    }
}
