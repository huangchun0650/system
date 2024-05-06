<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('nullable_in_order_consignees', function (Blueprint $table) {
            Schema::table('order_consignees', function (Blueprint $table) {
                $table->string('postal_code')->nullable()->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nullable_in_order_consignees', function (Blueprint $table) {
            Schema::table('order_consignees', function (Blueprint $table) {
                $table->string('postal_code')->nullable(FALSE)->change();
            });
        });
    }
};
