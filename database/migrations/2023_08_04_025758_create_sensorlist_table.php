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
     * [{"sensorType":"weight","sensorID":68},{"sensorType":"weight","sensorID":69},{"sensorType":"sensor","sensorID":74},{"sensorType":"sensor","sensorID":75}]
     */
    public function up()
    {
        Schema::create('sensorlist', function (Blueprint $table) {
            $table->id();
            $table->string('batchNumber');
            $table->string('sensorType');
            $table->string('sensorID');
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
        Schema::dropIfExists('sensorlist');
    }
};
