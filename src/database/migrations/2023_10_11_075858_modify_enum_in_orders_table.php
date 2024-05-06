<?php

use Illuminate\Database\Migrations\Migration;
use YFDev\System\App\Constants\OrderConstants;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $statusConstants = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'STATUS_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        $enumValues = "'" . implode("','", $statusConstants) . "'";

        // 1. 將 status 欄位轉換為 VARCHAR(255)。
        DB::statement('ALTER TABLE orders CHANGE status status VARCHAR(255)');

        // 2. 更新數據。
        DB::table('orders')->where('status', '審核未通過')->update(['status' => '已駁回']);

        // Assuming you are using MySQL
        DB::statement("ALTER TABLE orders CHANGE status status ENUM({$enumValues}) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
