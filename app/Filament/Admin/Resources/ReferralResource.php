<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ReferralResource\Pages;
use App\Filament\Admin\Resources\ReferralResource\RelationManagers;
use App\Models\Referral;
use App\Models\User;
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

class ReferralResource extends Resource
{
    protected static ?string $model = Referral::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('email', 'id'))
                    ->searchable(),
                Select::make('referrer_id')
                    ->label('Referred By')
                    ->options(User::all()->pluck('email', 'id'))
                    ->searchable(),

                TextInput::make('clicks'),
                TextInput::make('code'),
                TextInput::make('completed'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')->label('User')->searchable()->copyable()->sortable(),
                TextColumn::make('referredBy.email')->label('Referred By')->searchable()->copyable()->sortable(),
                TextColumn::make('clicks')->searchable()->copyable()->sortable(),
                TextColumn::make('completed')->searchable()->copyable()->sortable(),
                TextColumn::make('code')->searchable()->copyable()->sortable(),
                TextColumn::make('created_at')->searchable()->copyable()->sortable()->since(),
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
            'index' => Pages\ListReferrals::route('/'),
            'create' => Pages\CreateReferral::route('/create'),
            'edit' => Pages\EditReferral::route('/{record}/edit'),
        ];
    }
}
