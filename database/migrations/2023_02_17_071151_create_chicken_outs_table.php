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
        Schema::create('chicken_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contract::class)->constrained()->cascade(); // contract_id
            // $table->foreignIdFor(ChickenImport::class)->constrained()->cascade(); // chicken_import_id
            $table->string('chicken_import_id', 10)->default("ABCDEFGQAS")->comment('飼養批次');
            $table->string("building_number", 6)->default("A")->comment('棟舍號碼');
            $table->date('date')->nullable()->comment('出雞日期');
            $table->double('weight')->nullable()->comment('預估重量');
            $table->time('time')->nullable()->comment('出雞時間');
            $table->string('car_code')->nullable()->comment('車號');
            $table->string('origin')->nullable()->comment('地點'); # 產地
            // $table->string('weight_bridge')->nullable()->comment('地磅');
            $table->string('assistant')->nullable()->comment('助手');
            $table->string('worker')->nullable()->comment('抓雞工');
            $table->string('owner')->nullable()->comment('雞主');
            // $table->string('supplier')->nullable()->comment('供應商');
            $table->string('phone_number')->nullable()->comment('電話');
            $table->string('note')->nullable()->comment('備註');
            $table->integer('quantity')->nullable()->comment('隻數（羽）、出雞數量');
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
        Schema::dropIfExists('chicken_outs');
    }
};
