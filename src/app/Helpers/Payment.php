<?php

namespace YFDev\System\App\Helpers;

use YFDev\System\App\Exceptions\Payment\RtnException;
use YFDev\System\App\Traits\HashInfo;
use Exception;

class Payment
{
    use HashInfo;

    /**
     * Hash 方式列舉
     */
    public const METHOD_MD5 = 'md5';
    public const METHOD_SHA256 = 'sha256';

    /**
     * Hash 方式
     *
     * @var string
     */
    private $method;

    public function __construct($method)
    {
        $key = config('payment.hash_key');
        $iv = config('payment.hash_iv');

        $this->setHashKey($key);
        $this->setHashIv($iv);
        $this->setMethod($method);
    }

    /**
     * 自然排序
     *
     * @param  array $source
     * @return array
     */
    private static function naturalSort($source)
    {
        uksort($source, function ($first, $second) {

            return strcasecmp($first, $second);
        });
        return $source;
    }

    /**
     * 綠界 URL 編碼
     *
     * @param  string $source
     * @return string
     */
    private static function ecpayUrlEncode($source)
    {
        $encoded = urlencode($source);
        $lower = strtolower($encoded);
        $dotNetFormat = self::toDotNetUrlEncode($lower);

        return $dotNetFormat;
    }

    /**
     * 轉換為 .net URL 編碼結果
     *
     * @param  string $source
     * @return string
     */
    private static function toDotNetUrlEncode($source)
    {
        $search = [
            '%2d',
            '%5f',
            '%2e',
            '%21',
            '%2a',
            '%28',
            '%29',
        ];
        $replace = [
            '-',
            '_',
            '.',
            '!',
            '*',
            '(',
            ')',
        ];
        $replaced = str_replace($search, $replace, $source);

        return $replaced;
    }

    /**
     * 附加檢查碼
     *
     * @param  array   $source
     * @param  boolean $isSort
     * @return array
     */
    public function append($source, $isSort = TRUE)
    {
        $source[$this->getFieldName()] = $this->generate($source);
        if ($isSort) {
            $source = $this->sort($source);
        }

        return $source;
    }

    /**
     * 檢查碼參數過濾
     *
     * @param  array $source
     * @return array
     */
    public function filter($source)
    {
        if (isset($source[$this->getFieldName()])) {
            unset($source[$this->getFieldName()]);
        }

        return $source;
    }

    /**
     * 產生檢查碼
     *
     * @param  array $source
     * @return string
     *
     * @throws RtnException
     */
    public function generate($source)
    {
        try {
            $filtered = $this->filter($source);
            $sorted = $this->sort($filtered);
            $combined = $this->toEncodeSourceString($sorted);
            $encoded = $this->ecpayUrlEncode($combined);
            $hash = $this->generateHash($encoded);
            $checkMacValue = strtoupper($hash);
        } catch (Exception $e) {
            throw new RtnException(102);
        }

        return $checkMacValue;
    }

    /**
     * 產生雜湊值
     *
     * @param  string $source
     * @return string
     */
    public function generateHash($source)
    {
        $hash = '';
        if ($this->method === self::METHOD_SHA256) {
            $hash = hash('sha256', $source);
        } else {
            $hash = md5($source);
        }
        return $hash;
    }

    /**
     * 取得壓碼欄位名稱
     *
     * @return string
     */
    public function getFieldName()
    {
        return 'CheckMacValue';
    }

    /**
     * 設定雜湊方式
     *
     * @param string $method
     * @return void
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * 排序
     *
     * @param  array $source
     * @return array
     */
    public function sort($source)
    {
        return $this->naturalSort($source);
    }

    /**
     * 轉換為編碼來源字串
     *
     * @param  array $source
     * @return string
     */
    public function toEncodeSourceString($source)
    {
        $combined = 'HashKey=' . $this->getHashKey();
        foreach ($source as $name => $value) {
            $combined .= '&' . $name . '=' . $value;
        }
        $combined .= '&HashIV=' . $this->getHashIv();
        return $combined;
    }

    /**
     * 檢核檢查碼
     *
     * @param  array $source
     * @return boolean
     */
    public function verify($source)
    {
        $checkMacValue = $this->generate($source);
        return ($checkMacValue === $source[$this->getFieldName()]);
    }
}
