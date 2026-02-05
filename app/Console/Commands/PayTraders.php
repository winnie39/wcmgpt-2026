<?php

namespace App\Console\Commands;

use App\Http\Controllers\Helpers\TradeWorker;
use Illuminate\Console\Command;

class PayTraders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pay-traders';

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
        TradeWorker::payUsers();
    }
}
