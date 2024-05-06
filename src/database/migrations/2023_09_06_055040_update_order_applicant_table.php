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
        // Rename columns
        Schema::table('order_applicants', function (Blueprint $table) {
            if (Schema::hasColumn('order_applicants', 'postal_code')) {
                $table->renameColumn('postal_code', 'current_postal_code');
            }

            if (Schema::hasColumn('order_applicants', 'current_city')) {
                $table->renameColumn('current_city', 'current_city_region');
            }
        });

        // Adjust column lengths
        Schema::table('order_applicants', function (Blueprint $table) {
            if (Schema::hasColumn('order_applicants', 'current_postal_code')) {
                $table->string('current_postal_code', 10)->nullable()->change();
                $table->string('residence_landline', 15)->change();
                $table->string('current_city_region', 150)->change();
                $table->string('current_landline', 15)->change();
                $table->string('company_phone', 15)->change();
                $table->string('company_phone_extension', 15)->change();
                $table->string('contact1_mobile', 15)->change();
                $table->string('contact2_mobile', 15)->change();
            }

            if (Schema::hasColumn('order_applicants', 'mobile')) {
                $table->string('mobile', 20)->change();
            }
        });

        // Add new columns
        Schema::table('order_applicants', function (Blueprint $table) {
            $table->string('residence_city_region', 150)->after('birth_date')->nullable(FALSE)->comment('戶籍縣市區域');
            $table->string('residence_postal_code', 10)->after('residence_city_region')->nullable()->comment('戶籍郵遞區號');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_applicants', function (Blueprint $table) {
            $table->dropColumn('residence_city_region');
            $table->dropColumn('residence_postal_code');
        });

    }
};
