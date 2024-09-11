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
     * [{"batchNumber":"2023_0523","Date":"20230601","time":"00:00:16","sensorID":"69","weight":"0.239"}]
     */
    public function up()
    {
        Schema::create('raw_weights', function (Blueprint $table) {
            $table->id();
            $table->string('batchNumber')->comment('飼養批次、批號');
            $table->date('Date')->comment('數據收集日期');
            $table->time('time')->comment('數據收集時間');
            $table->string('sid')->comment('傳感器ID');
            $table->string('sensorID');
            $table->double('weight')->comment('測量的重量值');
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
        Schema::dropIfExists('raw_weights');
    }
};
