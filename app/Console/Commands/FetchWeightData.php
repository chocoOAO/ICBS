<?php

namespace App\Console\Commands;
use App\Http\Controllers\ExternalAPIController;
use Illuminate\Console\Command;


class FetchWeightData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:weightdata';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch weight data from external API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $controller = new ExternalAPIController();
        $controller->getWeightRaw();
        $controller->getPredictData();
        // Log::info('抓取資料');
        return Command::SUCCESS;
    }
}
