<?php

namespace App\Filament\Admin\Resources\ReferralLevelResource\Pages;

use App\Filament\Admin\Resources\ReferralLevelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReferralLevels extends ListRecords
{
    protected static string $resource = ReferralLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
