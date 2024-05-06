<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `orders` CHANGE `status` `status` ENUM('待審核','審核通過(理貨中)','待補件','已駁回','已成立','已取消','已補件','已完成') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '待審核'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
