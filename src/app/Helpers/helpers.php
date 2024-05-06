<?php

if (!function_exists('get_jwt')) {
    function get_jwt()
    {
        return Request::header('token');
    }
}

if (!function_exists('json_response')) {

    function json_response(): \App\Http\Responses\Response
    {
        return app('App\\Http\\Responses\\Response');
    }
}

if (!function_exists('device')) {
    function device()
    {
        return new \App\Extension\Device();
    }
}

if (!function_exists('is_valid_ipv4')) {
    /**
     * 判斷是否為有效的 IPv4
     *
     * @param $ip
     * @param  bool  $private
     * @return bool
     */
    function is_valid_ipv4($ip, bool $private = FALSE): bool
    {
        if ($private) {
            return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)
            && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        }

        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}

if (!function_exists('is_valid_ipv6')) {
    /**
     * 判斷是否為有效的 IPv6
     *
     * @param $ip
     * @param  bool  $private
     * @return bool
     */
    function is_valid_ipv6($ip, bool $private = FALSE): bool
    {
        if ($private) {
            return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)
            && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
        }

        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }
}

if (!function_exists('format_short_exception')) {
    /**
     * @param  Throwable  $e
     * @return string
     */
    function format_short_exception(string $class, \Throwable $e): string
    {
        return "[{$class}]" . PHP_EOL .
            "Message: {$e->getMessage()}" . PHP_EOL .
            "File: {$e->getFile()}" . PHP_EOL .
            "Line: {$e->getLine()}";
    }
}

if (!function_exists('telegram_notify')) {
    /**
     * Telegram 通知
     *
     * @return \Psr\Log\LoggerInterface
     */
    function telegram_notify(): \Psr\Log\LoggerInterface
    {
        return \Log::channel('telegram');
    }
}

if (!function_exists('parse_bool')) {
    /**
     * @param $value
     * @return bool
     */
    function parse_bool($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
