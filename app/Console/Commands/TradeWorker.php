<?php

namespace App\Console\Commands;

use App\Http\Controllers\Helpers\TradeWorker as HelpersTradeWorker;
use Illuminate\Console\Command;

class TradeWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:trade-worker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        HelpersTradeWorker::payUsers();
    }
}
