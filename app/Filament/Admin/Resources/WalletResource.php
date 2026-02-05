<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\WalletResource\Pages;
use App\Filament\Admin\Resources\WalletResource\RelationManagers;
use App\Models\User;
use App\Models\Wallet;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WalletResource extends Resource
{
    protected static ?string $model = Wallet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // TextInput::make(),
                Select::make('user_id')->options(User::all()->pluck('email', 'id')),
                TextInput::make('deposit'),
                TextInput::make('referral_commission'),
                TextInput::make('profits'),
                TextInput::make('stop_bot'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')->searchable(),
                TextColumn::make('deposit')->sortable(),
                TextColumn::make('referral_commission')->sortable(),
                TextColumn::make('profits')->sortable(),
                TextColumn::make('stop_bot')->sortable(),
                TextColumn::make('created_at')->sortable()->date(),
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
            'index' => Pages\ListWallets::route('/'),
            'create' => Pages\CreateWallet::route('/create'),
            'edit' => Pages\EditWallet::route('/{record}/edit'),
        ];
    }
}
