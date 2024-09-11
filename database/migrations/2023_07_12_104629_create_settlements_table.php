<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Contract;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            // $table->id();
            // 23種
            $table->id();
            // $table->foreignIdFor(Contract::class)->constrained()->cascade(); // contract_id
            $table->string('account_number')->comment('結帳單號'); // 帳款單號 
            $table->string('deduction_note')->nullable()->comment('額外的扣除金額(由使用者輸入的資料)'); // 用於存儲由使用者輸入的關於扣除金額的額外資訊。
            $table->integer('user_deduction_amount')->nullable()->comment('额外的扣除金额(由用户输入的数据)'); // 用於存儲由使用者輸入的關於扣除金額的額外資訊。PS.我想應該還不會太大吧，然後希望不要有小數。
            $table->string('plus_note')->nullable()->comment('加項金額的事項(由使用者輸入的資料)'); // 用於存儲由使用者輸入的關於加項金額的額外資訊。
            $table->integer('plus_amount')->nullable()->comment('加項金额(由用户输入的数据)'); // 用於存儲由使用者輸入的關於加項金額的額外資訊。PS.我想應該還不會太大吧，然後希望不要有小數。
            $table->string('other_note')->nullable()->comment('說明的額外事項 '); // 用於存儲由使用者輸入的關於其他說明的額外資訊。
            // $table->date('account_date')->comment('帳款日期');
            $table->date('weighing_date')->nullable()->comment('過磅日期'); 
            $table->string('batch')->nullable()->comment('批次'); // 福壽批次、importNum、import_number_id
            $table->string('breeder')->nullable()->comment('飼養戶');
            $table->string('livestock_farm_name')->nullable()->comment('畜牧場');
            $table->string('shift')->nullable()->comment('車次');
            $table->double('total_of_kilogram')->nullable()->comment('公斤重');
            // $table->string('total_of_quantity')->comment('總數量');
            $table->integer('total_of_birds')->nullable()->comment('合計羽數');
            // $table->string('')->comment('平均重量');
            $table->double('quotation')->nullable()->comment('報紙價'); // 不確定中文
            $table->double('fee')->nullable()->comment('手續費');
            $table->double('price')->nullable()->comment('單價');
            $table->integer('down_chicken')->nullable()->comment('下雞'); // 不知道什麼意思
            $table->integer('death')->nullable()->comment('死雞');
            $table->integer('discard')->nullable()->comment('剔除雞');
            $table->double('stinking_claw')->nullable()->comment('臭爪％');
            $table->double('stinking_chest')->nullable()->comment('臭胸％');
            $table->double('dermatitis')->nullable()->comment('皮膚炎％');
            $table->double('residue')->nullable()->comment('飼料殘留％');
            $table->string('memo')->nullable()->comment('備註');

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
        Schema::dropIfExists('settlements');
    }
};
