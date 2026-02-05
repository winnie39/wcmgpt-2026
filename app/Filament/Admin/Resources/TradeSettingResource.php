<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TradeSettingResource\Pages;
use App\Filament\Admin\Resources\TradeSettingResource\RelationManagers;
use App\Filament\Admin\Resources\TradeSettingResource\Widgets\TradeSettingOverview;
use App\Models\TradeSetting;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TradeSettingResource extends Resource
{
    protected static ?string $model = TradeSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('type')->readOnly(!in_array(auth()->user()->email, config('app.superadmins'))),
                TextInput::make('value')->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type'),
                TextColumn::make('value'),
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

    public static function getWidgets(): array
    {
        return [
            TradeSettingOverview::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTradeSettings::route('/'),
            'create' => Pages\CreateTradeSetting::route('/create'),
            'edit' => Pages\EditTradeSetting::route('/{record}/edit'),
        ];
    }
}
