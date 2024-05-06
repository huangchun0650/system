<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use YFDev\System\App\Constants\OrderConstants;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $areaOptions = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'LOCATION_TW_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        $typeOptions = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'TYPE_OF_ID_CARD_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        Schema::table('order_applicants', function (Blueprint $table) use ($typeOptions, $areaOptions) {
            $table->enum('id_issued_location', $areaOptions)->after('identity_type')->nullable(FALSE)->comment('身份證發證地點'); // 身份證發證地點
            $table->date('id_issued_date')->after('identity_type')->nullable(FALSE)->comment('身份證發證日期'); // 身份證發證日期
            $table->enum('id_issued_type', $typeOptions)->after('id_issued_location')->nullable(FALSE)->comment('身份證發證類別'); // 身份證發證類別
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
