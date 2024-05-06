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
        Schema::create('region_has_brands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('region_id')->comment('分區id');
            $table->unsignedBigInteger('brand_id')->comment('品牌id');
            $table->foreign('region_id')->references('id')->on('sub_regions')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->unique(['region_id', 'brand_id']); // Change primary key to unique key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region_has_brands');
    }
};
