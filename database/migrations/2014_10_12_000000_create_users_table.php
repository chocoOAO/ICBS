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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('用戶名稱');
           
            // 08/02 協理要求改為account，已完成
            $table->string('account')->unique()->comment('用戶帳號');
            $table->string('password')->comment('用戶密碼（加密）');
            $table->string('password_unencrypted')->comment('用戶密碼（未加密）'); // 名碼
            $table->string('auth_type')->default('worker')->comment('角色'); // 08/02原normal改為worker

            $table->rememberToken();

            // 08/02新增服務單位(意旨人員所屬之農場、福壽、洽富...等單位)，預設為null，理論上可由管理員進行設定
            // 可能使用service_unit 或 current_team_id 來做身分區分
            $table->string('service_unit')->nullable()->comment('服務單位');
            $table->foreignId('current_team_id')->nullable();
            // 上面兩個身分有點像。

            $table->string('profile_photo_path', 2048)->nullable()->comment('用戶頭像的路徑');

            // 會員操作CRUDP => 00000 , 有1 無0
            // $table->char('permissions', 5)->default('00000'); // 5個字元的欄位
            $table->char('permissions', 9)->default('111111111')->comment('用戶權限'); //9位元每個位元代表一個頁面的權限，2查看、3新增、4管理、

            //用來儲存客戶主檔
            $table->string('m_KUNAG')->nullable()->comment('客戶主檔');
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
        Schema::dropIfExists('users');
    }
};
