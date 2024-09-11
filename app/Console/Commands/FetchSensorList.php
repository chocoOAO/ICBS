<?php

namespace App\Console\Commands;
use App\Http\Controllers\ExternalAPIController;
use Illuminate\Console\Command;


class FetchSensorList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:sensorlist';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch sensorlist data from external API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $controller = new ExternalAPIController();
        $controller->getSensor();
        // Log::info('抓取資料');
        return Command::SUCCESS;
    }
}
