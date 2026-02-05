<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ShareResource\Pages;
use App\Filament\Admin\Resources\ShareResource\RelationManagers;
use App\Models\Share;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShareResource extends Resource
{
    protected static ?string $model = Share::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('email'),
                TextInput::make('rate'),
                TextInput::make('amount'),
                TextInput::make('currency')->default(config('app.currency')),
                Toggle::make('sender')->label('CEO'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('rate'),
                TextColumn::make('amount'),
                ToggleColumn::make('sender')->label('CEO'),
                TextColumn::make('currency')

            ])->defaultSort('sender', 'desc')
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
            'index' => Pages\ListShares::route('/'),
            'create' => Pages\CreateShare::route('/create'),
            'edit' => Pages\EditShare::route('/{record}/edit'),
        ];
    }
}
