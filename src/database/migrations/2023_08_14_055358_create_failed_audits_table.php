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
        Schema::create('failed_audits', function (Blueprint $table) {
            $table->id();  // 自動增加的主鍵
            $table->unsignedBigInteger('order_id')->comment('訂單Id'); // order_id 欄位
            $table->text('reason')->comment('原因');  // reason 欄位
            $table->timestamps();  // 自動建立的 created_at 和 updated_at 欄位

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_audits');
    }
};
