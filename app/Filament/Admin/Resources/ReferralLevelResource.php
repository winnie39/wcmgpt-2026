<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ReferralLevelResource\Pages;
use App\Filament\Admin\Resources\ReferralLevelResource\RelationManagers;
use App\Models\ReferralLevel;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReferralLevelResource extends Resource
{
    protected static ?string $model = ReferralLevel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('level'),
                TextInput::make('rate'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('level'),
                TextColumn::make('rate'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReferralLevels::route('/'),
            'create' => Pages\CreateReferralLevel::route('/create'),
            'edit' => Pages\EditReferralLevel::route('/{record}/edit'),
        ];
    }
}
