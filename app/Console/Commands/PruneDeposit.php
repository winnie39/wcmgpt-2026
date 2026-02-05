<?php

namespace App\Console\Commands;

use App\Http\Controllers\NowPaymentHelper;
use Illuminate\Console\Command;

class PruneDeposit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prune-deposit';

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
        (new NowPaymentHelper())->confirmNowPaymentDeposit();
    }
}
