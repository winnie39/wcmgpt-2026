<?php

namespace App\Filament\Admin\Resources\TradeSettingResource\Pages;

use App\Filament\Admin\Resources\TradeSettingResource;
use App\Filament\Admin\Resources\TradeSettingResource\Widgets\TradeSettingOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTradeSettings extends ListRecords
{
    protected static string $resource = TradeSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TradeSettingOverview::make(),
        ];
    }
}
