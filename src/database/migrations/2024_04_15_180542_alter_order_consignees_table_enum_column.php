<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `order_consignees` CHANGE `cargo_status` `cargo_status` ENUM('備貨中', '待審核','待發貨','已發貨','已交貨') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '備貨中'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
