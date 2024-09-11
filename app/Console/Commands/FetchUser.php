<?php

namespace App\Console\Commands;
use App\Http\Controllers\ExternalAPIController;
use Illuminate\Console\Command;
use App\Models\Contract;


class FetchUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:user';
    

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
        $ids = Contract::pluck('m_KUNAG');
        foreach($ids as $id)
        {
            $controller->getUserPassword($id);
        }
        // Log::info('抓取資料');
        return Command::SUCCESS;
    }
}
