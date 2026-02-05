<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TradeLogResource\Pages;
use App\Filament\Admin\Resources\TradeLogResource\RelationManagers;
use App\Models\TradeLog;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TradeLogResource extends Resource
{
    protected static ?string $model = TradeLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')->label('User')->options(User::get()->pluck('email', 'id'))->searchable(),
                TextInput::make('stake'),
                TextInput::make('symbol'),
                TextInput::make('rate'),
                TextInput::make('type'),
                TextInput::make('order_id'),
                DateTimePicker::make('bot_opening_time'),
                DateTimePicker::make('bot_closing_time'),
                TextInput::make('session_close_time'),
                TextInput::make('session_open_time'),
                TextInput::make('session_closing_price'),
                TextInput::make('session_opening_price'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')->searchable(),
                TextColumn::make('symbol')->searchable(),
                TextColumn::make('stake')->sortable(),
                TextColumn::make('rate'),
                TextColumn::make('type'),
                TextColumn::make('order_id'),
                TextColumn::make('bot_opening_time')->date(),
                TextColumn::make('bot_closing_time')->date(),
                TextColumn::make('session_close_time'),
                TextColumn::make('session_open_time'),
                TextColumn::make('session_opening_price'),
                TextColumn::make('session_closing_price'),
                TextColumn::make('created_at'),
            ])->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListTradeLogs::route('/'),
            'create' => Pages\CreateTradeLog::route('/create'),
            'edit' => Pages\EditTradeLog::route('/{record}/edit'),
        ];
    }
}
