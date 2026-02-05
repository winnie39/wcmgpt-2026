<?php

namespace App\Console\Commands;

use App\Http\Controllers\Helpers\SharesHelper;
use Illuminate\Console\Command;

class Shares extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:shares';

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
        // error_log('Sending shares');
        (new SharesHelper())->informShares();
    }
}
