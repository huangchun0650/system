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
        $housingOptions = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'HOUSING_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        $identityOptions = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'IDENTITY_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        $seniorityOptions = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'SENIORITY_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        $salaryOptions = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'SALARY_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        $telecomOptions = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'TELECOM_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        $relationshipOptions = array_filter(
            (new \ReflectionClass(OrderConstants::class))->getConstants(),
            function ($key) {
                return strpos($key, 'RELATIONSHIP_') === 0;
            },
            ARRAY_FILTER_USE_KEY
        );

        Schema::create('order_applicants', function (Blueprint $table) use (
            $housingOptions,
            $identityOptions,
            $seniorityOptions,
            $salaryOptions,
            $telecomOptions,
            $relationshipOptions
        ) {
            $table->id();
            $table->unsignedBigInteger('order_id')->comment('訂單Id')->nullable(FALSE);
            $table->enum('identity_type', $identityOptions)->comment('身份別')->nullable(FALSE);
            $table->date('birth_date')->comment('出生年月日')->nullable(FALSE);
            $table->string('residence_address')->comment('戶籍地址')->nullable(FALSE);
            $table->string('contact_email')->comment('常用聯絡Email')->nullable(FALSE);
            $table->string('residence_landline')->comment('戶籍市話')->nullable();
            $table->string('mobile')->comment('手機')->nullable(FALSE);
            $table->string('current_city')->comment('現住城市地區')->nullable(FALSE);
            $table->enum('telecom_operator', $telecomOptions)->comment('電信商');
            $table->string('postal_code')->comment('郵遞區號')->nullable(FALSE);
            $table->string('current_address')->comment('現住住址')->nullable(FALSE);
            $table->boolean('employment_status')->default(TRUE)->comment('工作狀態');
            $table->string('current_landline')->comment('現住市話')->nullable();
            $table->string('company_name')->comment('公司名稱')->nullable();
            $table->enum('housing_ownership', $housingOptions)->comment('住房所有權');
            $table->enum('seniority', $seniorityOptions)->comment('年資')->nullable();
            $table->boolean('has_credit_card')->comment('是否有信用卡');
            $table->enum('monthly_salary', $salaryOptions)->comment('月薪')->nullable();
            $table->string('company_phone')->comment('公司電話')->nullable();
            $table->string('company_phone_extension')->comment('公司電話分機')->nullable();
            $table->text('consultation_time')->comment('可照會時間')->nullable();
            $table->text('precautions')->comment('注意事項')->nullable();

            // 聯絡人
            $table->boolean('is_confidential')->comment('須保密');
            $table->string('contact1_name')->comment('聯絡人1姓名')->nullable(FALSE);
            $table->enum('contact1_relationship', $relationshipOptions)->comment('聯絡人1關係')->nullable(FALSE);
            $table->string('contact1_mobile')->comment('聯絡人1手機')->nullable(FALSE);
            $table->string('contact2_name')->comment('聯絡人2姓名')->nullable(FALSE);
            $table->enum('contact2_relationship', $relationshipOptions)->comment('聯絡人2關係')->nullable(FALSE);
            $table->string('contact2_mobile')->comment('聯絡人2手機')->nullable(FALSE);

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_applicants');
    }
};
