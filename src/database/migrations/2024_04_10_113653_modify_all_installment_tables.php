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
        Schema::rename('installment_types', 'installment_plans');

        Schema::dropIfExists('installment_options');

        Schema::dropIfExists('type_has_options');

        $identityOptions = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'IDENTITY_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        Schema::create('installment_identity', function (Blueprint $table) use ($identityOptions) {
            $table->id();
            $table->unsignedBigInteger('plan_id')->comment('分期型id');
            $table->enum('identity', $identityOptions)->comment('身份別')->nullable(FALSE);
            $table->foreign('plan_id')->references('id')->on('installment_plans')->onDelete('cascade');
        });

        Schema::create('installment_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identity_id')->constrained('installment_identity')->onDelete('cascade');
            $table->integer('periods')->comment('分期選項');
            $table->decimal('interest_rate', 4, 2)->comment('利率(%)');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['installment_type_id']);
            $table->renameColumn('installment_type_id', 'installment_plan_id');
            $table->foreign('installment_plan_id')->references('id')->on('installment_plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('installment_plans', 'installment_types');

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['installment_plan_id']);
            $table->renameColumn('installment_plan_id', 'installment_type_id');
            $table->foreign('installment_type_id')->references('id')->on('installment_types')->onDelete('cascade');
        });

        Schema::dropIfExists('installment_options');
        Schema::dropIfExists('installment_identity');

        Schema::create('type_has_options', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->comment('分期類型id');
            $table->unsignedBigInteger('option_id')->comment('分期選項id');
            $table->foreign('type_id')->references('id')->on('installment_types')->onDelete('cascade');
            $table->foreign('option_id')->references('id')->on('installment_options')->onDelete('cascade');
            $table->primary(['type_id', 'option_id']);
        });

        Schema::create('installment_options', function (Blueprint $table) {
            $table->id();
            $table->integer('option')->comment('分期選項');
            $table->decimal('rate', 4, 2)->comment('利率(%)');
            $table->timestamps();
        });
    }
};
