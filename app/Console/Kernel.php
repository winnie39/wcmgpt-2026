<?php

namespace App\Console;

use App\Http\Controllers\Helpers\ToastNotificationHelper;
use App\Http\Controllers\Helpers\TradeWorker;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:shares')->dailyAt('21:00')->timezone('UTC');
        $schedule->command('telescope:clear')->dailyAt('00:00')->timezone('UTC');


        $schedule->call(function () {
            TradeWorker::handleCompletedTrades();
        })->everySixHours();

        if (ToastNotificationHelper::night()) {
            $schedule->command('app:toast-notification')->everyTenSeconds();
        } else {
            $schedule->command('app:toast-notification')->everyFiveSeconds();
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
