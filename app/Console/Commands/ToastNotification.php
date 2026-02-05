<?php

namespace App\Console\Commands;

use App\Http\Controllers\Helpers\ToastNotificationHelper;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ToastNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:toast-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     */
    public function handle()
    {




        if (ToastNotificationHelper::night()) {

            $minSleepTime = 1;
            $maxSleepTime = 5;
        } else {
            $minSleepTime = 1;
            $maxSleepTime = 20;
        }


        $text =   ToastNotificationHelper::notify();
    }
}
