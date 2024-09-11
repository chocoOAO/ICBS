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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('Egg_In_date')->nullable();
            $table->integer('Egg_In_number')->nullable();
            $table->date('Chick_In')->nullable();
            $table->integer('Chick_In_number')->nullable();
            $table->date('Chicken_Out')->nullable();
            $table->integer('Chicken_Out_number')->nullable();
            $table->string('Memo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
