<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('m_KUNAG', 10)->default('')->comment('客戶代號'); // 因為還沒有客戶代號 所以先nullable
            $table->string('m_NAME', 255)->comment('客戶名稱、甲方名稱');
            $table->string('name_b', 255)->comment('客戶名稱、乙方名稱');
            $table->tinyInteger('type')->comment('合約類型，代養計價 或  其他事項(契養)');
            $table->date('begin_date')->comment('合約開始日期');
            $table->date('end_date')->comment('合約結束日期');

            $table->string('bank_name')->comment('金融機構、郵局名稱及分行名稱');
            $table->string('bank_branch')->comment('金融機構、郵局名稱及分行代號');
            $table->string('bank_account')->comment('金融帳號');

            $table->string('salary')->comment('月支酬勞');

            $table->string('office_tel')->nullable()->comment('公司連絡電話');
            $table->string('home_tel')->nullable()->comment('住家連絡電話');
            $table->string('mobile_tel')->nullable()->comment('手機連絡電話');

            $table->text('memo1')->nullable();
            $table->text('memo2')->nullable();

            // 合約建立者
            $table->string('creator')->nullable()->comment('建立者');
            $table->string('last_editor')->nullable()->comment('最後編輯者');
            $table->string('modified_log')->nullable()->comment('編輯紀錄');

            $table->primary(['id', 'm_KUNAG']);

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
        Schema::dropIfExists('contracts');
    }
};