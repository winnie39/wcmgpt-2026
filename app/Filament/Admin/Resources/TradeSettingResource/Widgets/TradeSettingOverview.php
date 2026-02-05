<?php

namespace App\Filament\Admin\Resources\TradeSettingResource\Widgets;

use App\Http\Controllers\Helpers\TradeSettingHelper;
use App\Models\Trade;
use App\Models\TradeSetting;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TradeSettingOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Current rate', $this->getCurrentRate()),
            Stat::make('Total stake',  TradeSettingHelper::getSetting(TradeSetting::TOTAL_STAKE)),
        ];
    }

    private function getCurrentRate()
    {

        $index = TradeSettingHelper::getSetting(TradeSetting::INDEX);
        $profit = TradeSettingHelper::getSetting(TradeSetting::PROFIT);
        $constant = TradeSettingHelper::getSetting(TradeSetting::CONSTANT);
        $totalStake = TradeSettingHelper::getSetting(TradeSetting::TOTAL_STAKE);
        $rate = $profit *   $constant / $totalStake;

        return $rate * 100 . '%';
    }
}
