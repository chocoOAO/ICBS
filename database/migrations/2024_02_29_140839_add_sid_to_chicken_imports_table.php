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
        Schema::table('chicken_imports', function (Blueprint $table) {
            //
            $table->string("chicken_sid")->nullable()->comment('場域碼');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chicken_imports', function (Blueprint $table) {
            //
            $table->dropColumn('chicken_sid');
        });
    }
};
