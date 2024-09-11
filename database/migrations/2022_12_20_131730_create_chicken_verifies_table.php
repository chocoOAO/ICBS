<?php

use App\Models\ChickenImport;
use App\Models\Contract;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chicken_verifies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contract::class)->constrained()->cascade(); // contract_id

            $table->date('date')->nullable()->comment('驗收日期');
            $table->integer('quantity')->nullable()->comment('驗收收量');
            $table->string('customer_name')->nullable()->comment('客戶姓名');
            $table->string('gift')->nullable()->comment('贈送%數');
            $table->integer('disuse')->nullable()->comment('淘汰數');
            // $table->integer('death_quantity')->nullable()->comment('死亡數量(死亡)');
            $table->integer('price')->nullable()->comment('單價(元/羽)');
            $table->integer('fee')->nullable()->comment('手續費');
            $table->integer('amount')->nullable()->comment('總羽數');
            $table->integer('money1')->nullable()->comment('代扣除雞款	公司款');
            $table->integer('money2')->nullable()->comment('客戶款');
            $table->string("memo1")->nullable()->comment('備註欄');


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
        Schema::dropIfExists('chicken_verifies');
    }
};
