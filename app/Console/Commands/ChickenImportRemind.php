<?php

namespace App\Console\Commands;

use App\Models\ChickenImport;
use Illuminate\Console\Command;

class ChickenImportRemind extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:chickenimports-remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check chickenimports and send reminders';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 查詢最新的工作表單填寫日期
        $latestSubmissionDate = ChickenImport::latest()->value('date');

        // 計算日期差
        $currentDate = now();
        $daysDifference = $currentDate->diffInDays($latestSubmissionDate);

        // 檢查日期差是否大於三天
        if ($daysDifference >= 3) {
            // 寄送提醒郵件給作業員和主管
            // 使用 Node.js Nodemailer

            $command = 'node resources/js/mailremind.js';
            exec($command, $output, $exitCode);

            if($exitCode === 0){
                $this->info('信件寄送成功');
            }else{
                $this->info('信件寄送失敗');
            }
        }

        return Command::SUCCESS;
    }
}
