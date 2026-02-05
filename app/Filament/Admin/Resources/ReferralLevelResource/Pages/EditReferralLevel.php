<?php

namespace App\Filament\Admin\Resources\ReferralLevelResource\Pages;

use App\Filament\Admin\Resources\ReferralLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReferralLevel extends EditRecord
{
    protected static string $resource = ReferralLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
