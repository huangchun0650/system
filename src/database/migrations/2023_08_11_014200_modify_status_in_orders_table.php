<?php

use Illuminate\Database\Migrations\Migration;
use YFDev\System\App\Constants\OrderConstants;

class ModifyStatusInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $statusConstants = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'STATUS_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        $enumValues = "'" . implode("','", $statusConstants) . "'";

        // Assuming you are using MySQL
        DB::statement("ALTER TABLE orders CHANGE status status ENUM({$enumValues}) NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // You also need to provide a way to revert the migration.
        // This is an example, adjust it according to your original ENUM values.
        DB::statement("ALTER TABLE orders CHANGE status status ENUM('established', 'shopping_cart', 'reviewing')");
    }
}
