<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Trade;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $depositsData = $this->getPaymentsData();

        return [
            Stat::make('Total stake', (float) Trade::sum('stake')),
            Stat::make('Total users', User::count()),
            Stat::make('Total users today', User::where('created_at', '>', Carbon::parse(now())->hour(00)->minute(0)->second(0))->count()),
            Stat::make('Total Deposits', Transaction::where('type', Transaction::DEPOSIT)->where('status', Transaction::COMPLETED)->sum('amount')),
            Stat::make('Pending Deposits', Transaction::where('type', Transaction::DEPOSIT)->whereRelation('user', function ($query) {
                return $query->whereNotIn('email', config('app.admins'));
            })->where('status', Transaction::PENDING)->sum('amount')),
            ...$depositsData,

        ];
    }

    protected function getPaymentsData()
    {

        $endDate = Carbon::now();
        $startDate = Carbon::now()->day(5)->month(2);

        $transactions = Transaction::where('type', Transaction::DEPOSIT)
            ->where('status', Transaction::COMPLETED)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->created_at->format('Y-m-d');
            })
            ->map(function ($transactionsForDay, $date) {
                $totalAmount = $transactionsForDay->sum('amount');
                return [
                    'date' => strtolower(Carbon::parse($date)->format('jS F')),
                    'amount' => $totalAmount,
                ];
            })
            ->values();
        $data = [];

        foreach ($transactions as $transaction) {
            $stat = Stat::make('Deposits on ' .  $transaction['date'], $transaction['amount']);
            array_push($data,  $stat);
        }

        return $data;
    }
}
