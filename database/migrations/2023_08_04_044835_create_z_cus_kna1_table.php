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
     *
     *
     *  m_KUNAG	NVARCHAR(10)		PRI	NULL		客戶代號	2023/08/01 add by vickey
     *	m_NAME	NVARCHAR(80)			NULL		客戶名稱	2023/08/01 add by vickey
     *	m_ADDSC	NVARCHAR(160)			NULL		地址	2023/08/01 add by vickey
     *
     */
    public function up()
    {
        Schema::create('z_cus_kna1s', function (Blueprint $table) {
            // $table->id();
            $table->string('m_KUNAG', 10)->primary();
            $table->string('m_NAME', 80);
            $table->string('m_ADDSC', 160);
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
        Schema::dropIfExists('z_cus_kna1s');
    }
};
