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
        Schema::create('breeding_performances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contract::class)->constrained()->cascade(); // contract_id
            // $table->foreignIdFor(ChickenImport::class)->constrained()->cascade(); // chicken_import_id
            $table->foreignUuid('chicken_import_id')->cascadeOnDelete();
            $table->string("building_number", 6)->default("A")->comment('棟舍號碼');
            $table->double('breeding_rate')->nullable()->comment('育成率');
            $table->double("avg_weight")->nullable()->comment('平均雛雞重');
            $table->double('feeding_efficiency')->nullable()->comment('飼料效率');
            $table->integer('age')->nullable()->comment('日齡');
            // $table->double('production_efficiency')->nullable()->comment('生產指數');
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
        Schema::dropIfExists('breeding_performances');
    }
};
