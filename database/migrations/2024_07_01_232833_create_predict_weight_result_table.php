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
        Schema::create('predict_weight_result', function (Blueprint $table) {
            $table->id();
            $table->string('contracts_id'); // 批次號字段
            $table->string('batchNumber'); // 批次號字段
            $table->string('sid')->nullable();
            $table->string('title'); // 標題字段
            $table->date('start'); // 預測重量字段
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
        Schema::dropIfExists('predict_weight_result');
    }
};
