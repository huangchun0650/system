<?php

namespace YFDev\System\App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TwIdNumber implements Rule
{
    protected $gender;

    public function __construct($gender)
    {
        $this->gender = $gender;
    }

    public function passes($attribute, $value)
    {
        // 身分證字號的地區
        $alphabet = [
            'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14,
            'F' => 15, 'G' => 16, 'H' => 17, 'I' => 34, 'J' => 18,
            'K' => 19, 'M' => 21, 'N' => 22, 'O' => 35, 'P' => 23,
            'Q' => 24, 'T' => 27, 'U' => 28, 'V' => 29, 'W' => 32,
            'X' => 30, 'Z' => 33,
        ];

        // 身分證字號 每個數字權重
        $weight = [1, 9, 8, 7, 6, 5, 4, 3, 2, 1, 1];

        // 檢查身分證字號的格式
        if (! preg_match('/^[A-Z][1-2][0-9]{8}$/', $value)) {
            return false;
        }

        // 檢查性别和身分證字號的第二個字符 - 性別碼
        if (($this->gender === 'male' && $value[1] != 1) ||
            ($this->gender === 'female' && $value[1] != 2)) {
            return false;
        }

        // 身分證字號的每個字符
        $characters = str_split(strtoupper($value));

        // 第一個字符是英文字母，轉換為相對應的兩個數字
        $number = $alphabet[$characters[0]];
        $characters[0] = $number / 10;
        array_splice($characters, 1, 0, $number % 10); // 在第二個位置插入地區的第二個數字

        // 每個字符轉換為數字
        $digits = array_map('intval', $characters);

        // 算總和
        $sum = array_sum(array_map(function ($weight, $digit) {
            return $weight * $digit;
        }, $weight, $digits));

        // 總和是10的倍數
        return $sum % 10 === 0;
    }

    public function message()
    {
        return 'The :attribute must be a valid Taiwan ID number.';
    }
}
