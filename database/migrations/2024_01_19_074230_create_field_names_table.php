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
        Schema::create('field_names', function (Blueprint $table) {

            // 更改 sid 資料型態
            // 執行 php artisan migrate:refresh --path=/database/migrations/2024_01_19_074230_create_field_names_table.php
            $table->string('sid')->nullable()->comment('場域編號');
            $table->string("shed_name")->nullable()->comment('場域名稱');
            $table->primary(['sid']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_names');
    }
};
