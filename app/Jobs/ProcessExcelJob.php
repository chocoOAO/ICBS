<?php

namespace App\Jobs;

use App\Http\Controllers\ExcelController;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue;

    protected $excelController;

    /**
     * Create a new job instance.
     *
     * @param  ExcelController  $excelController
     * @return void
     */
    public function __construct(ExcelController $excelController)
    {
        $this->excelController = $excelController;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 在这里放置处理 Excel 的逻辑
        $this->excelController->db_store();
    }
}
