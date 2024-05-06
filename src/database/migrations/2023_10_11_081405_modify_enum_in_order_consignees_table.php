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
                return strpos($key, 'SHIPMENT_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        $enumValues = "'" . implode("','", $statusConstants) . "'";

        DB::statement('ALTER TABLE order_consignees CHANGE cargo_status cargo_status VARCHAR(255)');
        DB::table('order_consignees')->where('cargo_status', '貨物退回')->update(['cargo_status' => '已交貨']);
        DB::statement("ALTER TABLE order_consignees CHANGE cargo_status cargo_status ENUM({$enumValues}) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
