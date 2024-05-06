<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('訂單id');
            $table->unsignedBigInteger('customer_id')->comment('顧客id');
            $table->string('signature_image')->nullable()->comment('親簽圖片');
            $table->unsignedBigInteger('product_id')->comment('商品id');
            $table->string('product_specification')->comment('商品規格');
            $table->unsignedInteger('product_installment')->comment('商品分期');
            $table->unsignedInteger('product_price')->comment('商品分期價格');
            $table->enum('status', ['established', 'shopping_cart', 'reviewing'])->comment('訂單狀態');
            $table->string('invoice_image')->nullable()->comment('發票圖片');
            $table->unsignedBigInteger('reviewer_id')->nullable()->comment('審核人員id');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('reviewer_id')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
