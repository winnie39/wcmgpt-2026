<?php

namespace App\Filament\Admin\Resources\TradeSettingResource\Pages;

use App\Filament\Admin\Resources\TradeSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTradeSetting extends EditRecord
{
    protected static string $resource = TradeSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
