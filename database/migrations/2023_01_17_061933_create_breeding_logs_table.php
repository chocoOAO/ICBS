<?php

use App\Models\Contract;
use App\Models\ChickenImport;
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
        Schema::create('breeding_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contract::class)->constrained()->cascade()->comment('合約代號'); // contract_id
            $table->string('chicken_import_id', 10)->default("ABCDEFGQAS")->comment('飼養批次');
            $table->string("building_number", 6)->default("A")->comment('棟舍號碼');
            $table->date('date')->nullable()->comment('日期');
            $table->integer('age')->nullable()->comment('日齡');
            $table->integer('disuse')->nullable()->comment('淘汰數');
            $table->double('breeding_rate')->nullable()->comment('育成率');
            $table->double('am_avg_weight')->nullable()->comment('上午均重');
            $table->double('pm_avg_weight')->nullable()->comment('下午均重');
            $table->string('creator')->nullable()->comment('建立者');
            $table->string('last_editor')->nullable()->comment('最後編輯者');
            $table->string('modified_log')->nullable()->comment('編輯紀錄');
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
        Schema::dropIfExists('breeding_logs');
    }
};
