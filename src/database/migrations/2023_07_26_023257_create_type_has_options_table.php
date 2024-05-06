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
        Schema::create('type_has_options', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->comment('分期類型id');
            $table->unsignedBigInteger('option_id')->comment('分期選項id');
            $table->foreign('type_id')->references('id')->on('installment_types')->onDelete('cascade');
            $table->foreign('option_id')->references('id')->on('installment_options')->onDelete('cascade');
            $table->primary(['type_id', 'option_id']); // set the combination of type_id and option_id as primary key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_has_options');
    }
};
