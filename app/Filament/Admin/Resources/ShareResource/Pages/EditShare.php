<?php

namespace App\Filament\Admin\Resources\ShareResource\Pages;

use App\Filament\Admin\Resources\ShareResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShare extends EditRecord
{
    protected static string $resource = ShareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
