<?php
/*
 * @Author:
 * @Date: 2023-07-26 10:05:38
 * @LastEditors: Please set LastEditors
 * @LastEditTime: 2023-07-26 10:53:32
 * @Description:
 */

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('商品名稱');
            $table->unsignedBigInteger('price')->comment('商品總價'); // total price
            $table->json('specifications')->comment('商品規格'); // specifications as JSON
            $table->unsignedBigInteger('installment_type_id')->comment('商品分期類型');
            $table->unsignedBigInteger('region_id')->comment('商品分區id');
            $table->unsignedBigInteger('brand_id')->comment('商品品牌id');
            $table->foreign('region_id')->references('id')->on('sub_regions')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('installment_type_id')->references('id')->on('installment_types')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
};
