<?php

namespace App\Filament\Admin\Resources\TradeLogResource\Pages;

use App\Filament\Admin\Resources\TradeLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTradeLogs extends ListRecords
{
    protected static string $resource = TradeLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
