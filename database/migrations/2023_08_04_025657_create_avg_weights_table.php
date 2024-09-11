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
     * [{"batchNumber":"2023_0523","Date":"20230615","weightFieldAvg":"1090","weightFieldEvenness":"7.69","growthRate":73}]
     */
    public function up()
    {
        Schema::create('avg_weights', function (Blueprint $table) {
            $table->id();
            $table->string('batchNumber');
            $table->date('Date');
            $table->double('weightFieldAvg');
            $table->double('weightFieldEvenness');
            $table->double('growthRate');
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
        Schema::dropIfExists('avg_weights');
    }
};
