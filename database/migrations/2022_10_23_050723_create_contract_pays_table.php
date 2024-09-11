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
        Schema::create('contract_pays', function (Blueprint $table) {
            $table->uuid()->primary();

            $table->integer('bag_pay');
            $table->integer('car_pay');

            $table->integer('meet1');
            $table->integer('meet2');
            $table->integer('meet3');
            $table->integer('once_chick_price');

            $table->integer('chicken_weight_price1');
            $table->integer('chicken_weight_price2');
            $table->integer('chicken_weight_price3');
            $table->integer('chicken_weight_price4');
            $table->integer('chicken_weight_price5');
            $table->integer('chicken_weight_price6');

            $table->integer('chicken_allowance_price1');
            $table->integer('chicken_allowance_price2');
            $table->integer('chicken_allowance_price3');
            $table->integer('chicken_allowance_price4');
            $table->integer('chicken_allowance_price5');
            $table->integer('chicken_allowance_price6');

            $table->integer('chicken_weight_kg_1_1');
            $table->integer('chicken_weight_kg_1_2');

            $table->integer('chicken_weight_kg_2_1');
            $table->integer('chicken_weight_kg_2_2');

            $table->integer('chicken_weight_kg_3_1');
            $table->integer('chicken_weight_kg_3_2');

            $table->integer('chicken_weight_kg_4_1');
            $table->integer('chicken_weight_kg_4_2');

            $table->integer('chicken_weight_kg_5_1');
            $table->integer('chicken_weight_kg_5_2');

            $table->integer('chicken_weight_kg_6_1');
            $table->integer('chicken_weight_kg_6_2');


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
        Schema::dropIfExists('contract_pays');
    }
};
