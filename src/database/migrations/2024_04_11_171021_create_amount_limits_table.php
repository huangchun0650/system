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
        Schema::create('amount_limits', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('age_from');
            $table->unsignedInteger('age_to');
            $table->unsignedInteger('amount_limit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amount_limits');
    }
};
