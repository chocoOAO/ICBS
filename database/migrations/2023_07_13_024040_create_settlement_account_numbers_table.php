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
        Schema::create('settlement_account_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->comment('帳款單號'); // 暫時寫死
            $table->date('account_date')->comment('帳款日期');
            $table->date('weighinh_date')->comment('過帳日期');
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
        Schema::dropIfExists('settlement_account_numbers');
    }
};
