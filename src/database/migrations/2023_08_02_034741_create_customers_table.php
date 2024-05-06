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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('姓名');
            $table->string('id_number')->unique()->comment('身分證字號');
            $table->string('password')->comment('密碼');
            $table->enum('gender', ['male', 'female'])->comment('性別');
            $table->date('birthday')->comment('生日');
            $table->string('identity')->nullable()->comment('身份別');
            $table->string('phone')->nullable()->comment('手機號碼');
            $table->string('email')->unique()->comment('電子郵件帳號');
            $table->string('line_id')->nullable()->comment('Line ID');
            $table->string('fb_id')->nullable()->comment('FB ID');
            $table->string('residence_phone')->nullable()->comment('戶籍電話');
            $table->string('current_phone')->nullable()->comment('現住電話');
            $table->text('residence_address')->nullable()->comment('戶籍地址');
            $table->text('current_address')->nullable()->comment('現住地址');
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
        Schema::dropIfExists('customers');
    }
};
