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
        Schema::create('breeding_standards', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->string('species', 4)->nullable()->comment('雞種');
            $table->char('standard_year', 4)->nullable()->comment('標準年份');
            $table->integer('age')->nullable()->comment('日齡');
            $table->double('avg_weight')->nullable()->comment('平均重量');
            $table->double('daily_gain')->nullable()->comment('日增重');

            $table->primary(['species', 'standard_year', 'age']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('breeding_standards');
    }
};
