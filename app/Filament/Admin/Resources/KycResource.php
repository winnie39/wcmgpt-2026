<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KycResource\Pages;
use App\Filament\Admin\Resources\KycResource\RelationManagers;
use App\Http\Controllers\User\UserController;
use App\Mail\KycCompleted;
use App\Mail\KycRejected;
use App\Models\Country;
use App\Models\Kyc;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Mail;

class KycResource extends Resource
{
    protected static ?string $model = Kyc::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                Select::make('user_id')->label('User')->options(User::all()->pluck('name', 'id')),
                Select::make('country_id')->label('Country')->options(Country::all()->pluck('name', 'id')),
                TextInput::make('document_type'),
                TextInput::make('address'),
                Toggle::make('verified'),
                Toggle::make('pending'),
                Toggle::make('rejected'),
                FileUpload::make('document_1')->image(),
                FileUpload::make('document_2')->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.email')->label('User')->searchable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('address')->searchable(),
                TextColumn::make('document_type')->searchable(),
                // ToggleColumn::make('verified'),
                // ToggleColumn::make('rejected'),
                ImageColumn::make('document_1')->label('Document'),
                ImageColumn::make('document_2')->label('Photo'),
                TextColumn::make('country.name'),
            ])
            ->filters([
                //
            ])->defaultSort('pending', 'desc')
            ->actions([

                Tables\Actions\Action::make('Reject')->size('xs')->button()->color('danger')->requiresConfirmation()->hidden(function (Kyc $kyc) {
                    if ($kyc->pending) {
                        return false;
                    }

                    return true;
                })->action(function (Kyc $kyc) {
                    UserController::rejectKyc($kyc->id);
                }),
                Tables\Actions\Action::make('Approve')->color('info')->size('xs')->button()->requiresConfirmation()->action(function (Kyc $kyc) {
                    UserController::ApproveKyc($kyc->id);
                })->hidden(function (Kyc $kyc) {
                    if ($kyc->pending) {
                        return false;
                    }

                    return true;
                }),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListKycs::route('/'),
            'create' => Pages\CreateKyc::route('/create'),
            'edit' => Pages\EditKyc::route('/{record}/edit'),
        ];
    }
}
