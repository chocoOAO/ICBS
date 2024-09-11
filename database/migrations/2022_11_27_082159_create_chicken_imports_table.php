<?php

use App\Models\Contract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *
     */
    public function up()
    {
        // 入雛表
        Schema::create('chicken_imports', function (Blueprint $table) {
            $table->string('id', 10)->default("ABCDEFGQAS")->comment('飼養批次');
            $table->string("m_KUNAG", 10)->default(Str::random(10))->comment('客戶代號');
            $table->string("building_number", 6)->default("A")->comment('棟舍號碼');
            $table->foreignIdFor(Contract::class)->constrained()->cascade()->comment('合約代號'); // contract_id
            $table->date("date")->nullable()->comment('入雛日期');
            $table->enum('species', ['AA','ROSS','COBB'])->nullable()->comment('雞種');
            $table->integer("quantity")->nullable()->comment('入雛數量');
            $table->integer("gift_quantity")->nullable()->comment('贈送數量');
            $table->integer("amount")->nullable()->comment('總數');
            $table->integer("actual_quantity")->nullable()->comment('實際數量');
            $table->double("price")->nullable()->comment('單價(元/羽)');
            $table->integer("package_quantity")->nullable()->comment('包裝(隻)');
            $table->integer("package")->nullable()->comment('包裝(箱)');
            $table->double("avg_weight")->nullable()->comment('平均雛雞重');
            $table->double("actual_avg_weight")->nullable()->comment('實磅平均雛雞重');
            $table->double("total_weight")->nullable()->comment('總重');
            $table->string("picture_url")->nullable()->comment('收執聯照片');
            $table->string("address")->nullable()->comment('地址');
            $table->string("chicken_origin", 10)->nullable()->comment('雛雞來源');
            $table->string("Memo1")->nullable()->comment('備註欄');

            // 新增欄位，存取場域碼
            // 執行 php artisan migrate:refresh --path=/database/migrations/2022_11_27_082159_create_chicken_imports_table.php
            // $table->string("sid")->nullable()->comment('場域碼');

            $table->string('creator')->nullable()->comment('建立者');
            $table->string('last_editor')->nullable()->comment('最後編輯者');
            $table->string('modified_log')->nullable()->comment('編輯紀錄');

            $table->primary(['id', 'm_KUNAG','building_number']);

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
        Schema::dropIfExists('chicken_imports');
    }
};
