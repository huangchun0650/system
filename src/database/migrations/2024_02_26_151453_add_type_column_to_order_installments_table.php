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
        Schema::table('order_installments', function (Blueprint $table) {
            $table->enum('type', ['分期單', '滯納金'])->default('分期單')->after('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_installments', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
