<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ChickenImport;

class ProcessAPIsix implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = "http://1.34.47.251:28888/api/client/batch_add.php";

        $batchLogs = ChickenImport::all(['id', 'chicken_sid', 'date', 'quantity']);

        foreach ($batchLogs as $batchLog) {
            $sid = $batchLog->chicken_sid;
            $batchNumber = $batchLog->id;
            $startDate = $batchLog->date;
            $quantity = $batchLog->quantity;

            $params = [
                'sid' => $sid,
                'batchNumber' => $batchNumber,
                'start_date' => $startDate,
                'quantity' => $quantity,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        }
    }
}
