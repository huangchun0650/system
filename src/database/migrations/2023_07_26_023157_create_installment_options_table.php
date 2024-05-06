<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installment_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('option')->comment('分期選項');
            $table->decimal('rate', 4, 2)->comment('利率(%)'); // Add a comment to the rate column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installment_options');
    }
};
