<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TradeResource\Pages;
use App\Filament\Admin\Resources\TradeResource\RelationManagers;
use App\Models\Trade;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TradeResource extends Resource
{
    protected static ?string $model = Trade::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('email', 'id'))->searchable()->rules(['numeric']),
                TextInput::make('stake')->rules(['numeric']),
                Toggle::make('status'),
                TextInput::make('paid')->rules(['numeric']),
                TextInput::make('target')->rules(['numeric']),
                TextInput::make('stake')->rules(['numeric']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')->searchable(),
                TextColumn::make('stake')->sortable(),
                TextColumn::make('target'),
                TextColumn::make('paid')->sortable(),
                ToggleColumn::make('status'),
            ])
            ->filters([
                //
            ])->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListTrades::route('/'),
            'create' => Pages\CreateTrade::route('/create'),
            'edit' => Pages\EditTrade::route('/{record}/edit'),
        ];
    }
}
