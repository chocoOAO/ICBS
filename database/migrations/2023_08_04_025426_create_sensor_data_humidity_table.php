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
     * [{"batchNumber":"2023_0523","Date":"2023-06-06","time":"17:57:42","sensorID":"74","humidity":75},]
     */
    public function up()
    {
        Schema::create('sensor_data_humidity', function (Blueprint $table) {
            $table->id();
            $table->string('batchNumber');
            $table->date('Date');
            $table->time('time');
            $table->string('sensorID');
            $table->integer('humidity');
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
        Schema::dropIfExists('sensor_data_humidity');
    }
};
