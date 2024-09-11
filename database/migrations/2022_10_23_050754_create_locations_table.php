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
        Schema::create('locations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('customer_id');
            $table->tinyInteger('type');

            $table->string('name');
            $table->string('address');

            // 我看他的規劃裡面沒有
            $table->string('area')->comment('面積');

            $table->string('feed_address')->comment('飼養地段');
            $table->string('feed_number')->comment('飼號');

            $table->string('building_name1');
            $table->string('feed_amount1');

            $table->string('building_name2');
            $table->string('feed_amount2');

            $table->string('buildings_name3');
            $table->string('feed_amount3');

            $table->string('phone_number')->comment('電話號碼');

            $table->string('per_buinding_chicken_amount')->comment('不確定這個是幹嘛的');

            $table->text('tips');

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
        Schema::dropIfExists('locations');
    }
};
