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
        Schema::create('feeding_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contract::class)->constrained()->cascade()->comment('合約代號'); // contract_id
            $table->string('chicken_import_id', 10)->default("ABCDEFGQAS")->comment('飼養批次');
            $table->string("building_number", 6)->default("A")->comment('棟舍號碼');
            $table->string('m_KUNAG', 10)->nullable()->comment('客戶代號');
            $table->date('date')->nullable()->comment('日期');
            $table->string('feed_type')->nullable()->comment('飼養行為'); // "飼養行為(A,B,C,D) A飼料 B疫苗 C藥品 D消毒 註：僅A類別需計算累計量"
            $table->string('feed_item')->nullable()->comment('投料名稱');
            $table->integer('feed_quantity')->nullable()->comment('用料量(kg)');
            $table->integer('feed_cumulant')->default(0)->comment('飼料累計量(kg)');
            $table->boolean('add_antibiotics')->default(false)->comment('是否含抗生素(Y/N)');
            $table->double('feeding_efficiency')->nullable()->comment('飼效');
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
        Schema::dropIfExists('feeding_logs');
    }
};
