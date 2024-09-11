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
     * [{"batchNumber":"2023_0523","Date":"20230523","time":"00:16:02","sensorID":"46","water":66476.571}]
     */

    public function up()
    {
        Schema::create('water', function (Blueprint $table) {
            $table->id();
            $table->string('batchNumber');
            $table->date('Date');
            $table->time('time');
            $table->string('sensorID');
            $table->double('water');
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
        Schema::dropIfExists('water');
    }
};
