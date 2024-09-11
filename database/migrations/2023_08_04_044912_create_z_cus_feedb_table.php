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
     * m_KUNAG	NVARCHAR(10)		PRI	NULL		客戶代號
     * chicken_import_id	bigint unsigned	NO	PRI	NULL		入雛批號
     * chickent_id_apdate	NVARCHAR(8)	YES		NULL		飼養批號核准日
     * chickent_id_stdate	NVARCHAR(8)	YES		NULL		飼養批號生效日
     * chickent_id_enddate	NVARCHAR(8)	YES		NULL		飼養批號失效日
     * chicken_import_date	NVARCHAR(8)	YES		NULL		預計入雛日期
     */
    public function up()
    {
        Schema::create('z_cus_feedbs', function (Blueprint $table) {
            $table->string('m_KUNAG', 10)->primary();
            $table->bigInteger('chicken_import_id')->unsigned();
            $table->string('chickent_id_apdate', 8)->nullable();
            $table->string('chickent_id_stdate', 8)->nullable();
            $table->string('chickent_id_enddate', 8)->nullable();
            $table->string('chicken_import_date', 8)->nullable();
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
        Schema::dropIfExists('z_cus_feedbs');
    }
};
