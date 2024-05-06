<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use YFDev\System\App\Constants\OrderConstants;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $cargoOptions = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'SHIPMENT_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        Schema::create('order_consignees', function (Blueprint $table) use ($cargoOptions) {
            $table->id();
            $table->unsignedBigInteger('order_id')->unique()->comment('訂單ID');
            $table->enum('cargo_status', $cargoOptions)->default('待審核')->comment('貨物狀態')->nullable(FALSE);
            $table->string('name')->comment('收貨人姓名')->nullable(FALSE);
            $table->string('city_region')->comment('收貨縣市區域')->nullable(FALSE);
            $table->string('postal_code')->comment('郵遞區號')->nullable(FALSE);
            $table->string('address')->comment('收貨地址')->nullable(FALSE);
            $table->string('landline')->comment('收貨人市話')->nullable();
            $table->string('mobile')->comment('收貨人手機')->nullable(FALSE);
            $table->text('notes')->comment('收貨備註')->nullable();
            $table->boolean('needs_tax_id')->default(FALSE)->comment('是否需要統一編號');
            $table->string('tax_id')->comment('統一編號')->nullable();
            $table->string('company_title')->comment('公司抬頭')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('order_consignees');
    }
};
