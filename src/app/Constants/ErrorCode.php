<?php

namespace YFDev\System\App\Constants;

final class ErrorCode
{
    /**
     * 系統型錯誤
     */
    public const SYSTEM_ERROR = 100000; // 系統錯誤
    public const GUZZLE_ERROR = 100001; // 連線錯誤

    /**
     * 中間件驗證
     */
    public const PERMISSION_DENIED = 100101; // 權限不足
    public const REPEAT_POST = 100102; // 重複提交表單
    public const JWT_EMPTY = 100103; // JWT TOKEN 不存在
    public const JWT_INVALID = 100104; // 無效的 JWT TOKEN
    public const INVALID_REQUEST = 100105; // 無效的請求
    public const BEHAVIOR_LOCK = 100106; // 資料變動 (須重新整理或重試)

    /**
     * 請求參數驗證
     */
    public const PARAMETERS_ERROR = 200001; // 參數錯誤
    public const NAME_DUPLICATE_ERROR = 200002; // 名稱重複
    public const CAPTCHA_ERROR = 200003; // 驗證碼錯誤
    public const INVALID_CREDENTIALS = 200004; // 無效的驗證
    public const USING_CANNOT_DELETE = 200004; // 使用中無法刪除
}
