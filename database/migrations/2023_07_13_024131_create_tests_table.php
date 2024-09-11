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
     *
     * 這個檔案是用來測試用的，隨時會更改內容，沒有一定要使用
     *
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            // $table->id();
            // 23種
            
            $table->id();
            // $table->foreignIdFor(Contract::class)->constrained()->cascade(); // contract_id
            $table->integer('number')->nullable()->comment('序號');
            $table->string('source')->nullable()->comment('來源');
            $table->string('traceability')->nullable()->comment('產銷履歷');
            $table->date('weighing_date')->nullable()->comment('過磅日期');
            $table->string('chicken_imports_id')->nullable()->comment('福壽批次');
            $table->string('account_number')->nullable()->comment('結帳單號'); // 暫時寫死
            $table->string('breeder')->nullable()->comment('飼養戶');
            $table->string('livestock_farm_name')->nullable()->comment('畜牧場');
            $table->string('batch')->nullable()->comment('車次');
            $table->string('car_number')->nullable()->comment('車號');
            $table->string('description')->nullable()->comment('說明');
            $table->double('kilogram_weight')->nullable()->comment('公斤重');
            // $table->string('total_of_quantity')->comment('總數量');
            $table->double('catty_weight')->nullable()->comment('台斤重');
            // $table->string('')->comment('平均重量');
            $table->double('total_of_birds')->nullable()->comment('合計羽數'); // 不確定中文
            $table->double('average_weight')->nullable()->comment('平均重量');
            $table->integer('down_chicken')->nullable()->comment('下雞'); // 不知道什麼意思
            $table->integer('death')->nullable()->comment('死雞');
            $table->integer('discard')->nullable()->comment('剔除雞');
            $table->double('stinking_claw')->nullable()->comment('臭爪％');
            $table->double('dermatitis')->nullable()->comment('皮膚炎％');
            $table->double('stinking_chest')->nullable()->comment('臭胸％');
            $table->double('residue')->nullable()->comment('飼料殘留％');
            $table->double('price_of_newspaper')->nullable()->comment('報紙價'); // 不確定中文
            $table->double('unit_price')->nullable()->comment('單價');
            $table->string('notes')->nullable()->comment('備註');
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
        Schema::dropIfExists('tests');
    }
};
