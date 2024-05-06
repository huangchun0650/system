<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use YFDev\System\App\Constants\OrderConstants;

class ModifyCustomersTable extends Migration
{
    public function up()
    {
        $constants = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'IDENTITY_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        $enumValues = array_values($constants);
        $formattedEnumValues = "'" . implode("','", $enumValues) . "'";
        $general = "'" . OrderConstants::IDENTITY_GENERAL . "'";

        DB::statement("ALTER TABLE customers CHANGE identity identity ENUM({$formattedEnumValues}) NOT NULL DEFAULT {$general} COMMENT '身份別'");

        Schema::table('customers', function (Blueprint $table) {
            // 修改 currentPhone 和 phone 欄位
            $table->string('name', 50)->change();
            $table->string('id_number', 10)->change();
            $table->string('current_phone', 20)->change();
            $table->string('phone', 20)->nullable(FALSE)->change();
            $table->string('residence_phone', 20)->change();
            $table->string('line_id', 80)->change();
            $table->string('fb_id', 80)->change();
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            // 這裡你可以進行逆操作以還原你的修改，如果需要的話
        });
    }
}
