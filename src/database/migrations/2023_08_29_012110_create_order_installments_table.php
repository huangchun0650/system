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
        Schema::create('order_installments', function (Blueprint $table) {
            $table->id()->comment('分期付款ID');
            $table->unsignedBigInteger('order_id')->comment('訂單ID');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->integer('installment_number')->comment('分期付款編號');
            $table->enum('status', ['未支付', '已支付', '逾期(未支付)', '逾期(已支付)'])->default('未支付')->comment('分期付款狀態');
            $table->boolean('is_approved')->default(FALSE)->comment('審核狀態');
            $table->date('paid_on')->nullable()->comment('客戶支付日期');
            $table->date('due_date')->comment('帳單到期日期');
            $table->decimal('amount', 8, 2)->comment('單期付款金額');
            $table->decimal('total_amount', 8, 2)->comment('總付款金額');
            $table->decimal('remaining_amount', 8, 2)->comment('剩餘待支付金額');
            $table->text('description')->nullable()->comment('描述或備註');
            $table->string('payment_method')->nullable()->comment('分期付款的支付方式');
            $table->string('transaction_id')->nullable()->comment('分期付款交易ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_installments');
    }
};
