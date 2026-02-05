<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TransactionResource\Pages;
use App\Filament\Admin\Resources\TransactionResource\RelationManagers;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawController;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::all()->pluck('email', 'id'))->searchable()->rules('required'),
                TextInput::make('description'),
                TextInput::make('amount')->rules('required'),
                TextInput::make('code')->rules('required'),
                TextInput::make('amount_before_deduction')->rules('required'),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        0 => 'CANCELLED',
                        3 => 'UNCONFIRMED',
                        1 => 'PENDING',
                        2 => 'COMPLETED',
                    ])
                    ->searchable()->rules('required'),
                TextInput::make('type')->rules('required'),
                FileUpload::make('image')->image()->imageEditor(),
                TextInput::make('address')->rules('required'),
                TextInput::make('currency')->rules('required'),
                TextInput::make('method')->rules('required'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount')->sortable(),
                TextColumn::make('address')->searchable()->sortable()->copyable(),
                ImageColumn::make('image'),
                TextColumn::make('user.email')->searchable()->sortable(),
                TextColumn::make('description')->searchable()->sortable(),
                TextColumn::make('amount_before_deduction'),
                TextColumn::make('code')->sortable(),
                TextColumn::make('status_text')->sortable(),
                TextColumn::make('currency')->sortable(),
                TextColumn::make('type_text')->sortable(),
                TextColumn::make('method')->searchable()->sortable(),
                TextColumn::make('created_at')->label('date')->searchable(),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')->options([
                    Transaction::DEPOSIT => 'DEPOSIT',
                    Transaction::WITHDRAWAL => 'WITHDRAWAL',
                    Transaction::INVESTMENT => 'INVESTMENTS',
                    Transaction::SIGNUP_BONUS => 'SIGNUP BONUS',
                    Transaction::P2P_TRANSFER_SEND => 'P2P_TRANSFER_SEND',
                    Transaction::P2P_TRANSFER_RECEIVE => 'P2P_TRANSFER_RECEIVE',
                    Transaction::REFERRALS => 'REFERRALS',
                    Transaction::P2P_TRANSFER_PROFIT => 'P2P_TRANSFER_PROFIT'
                ])->searchable(),

                SelectFilter::make('status')->options([
                    Transaction::COMPLETED => 'COMPLETED',
                    Transaction::UNCOMPLETED => 'UNCOMPLETED',
                    Transaction::PENDING => 'PENDING',
                    Transaction::FAILED => 'FAILED',
                ])->searchable(),
            ])

            ->actions([
                Tables\Actions\Action::make('Approve')->color('info')->size('xs')->button()->requiresConfirmation()->action(function (Transaction $transaction) {
                    if ($transaction['type'] == Transaction::DEPOSIT) {
                        DepositController::approveManualDeposit($transaction->id);
                    } else {
                        WithdrawController::approveWithdraw($transaction->id);
                    }
                })->hidden(function (Transaction $transaction) {
                    if ($transaction->status == Transaction::PENDING && ($transaction->type == Transaction::DEPOSIT || $transaction->type == Transaction::WITHDRAWAL)) {
                        return false;
                    }

                    return true;
                }),
                Tables\Actions\Action::make('Reject')->size('xs')->button()->color('danger')->requiresConfirmation()->hidden(function (Transaction $transaction) {
                    if ($transaction->status == Transaction::PENDING && ($transaction->type == Transaction::DEPOSIT || $transaction->type == Transaction::WITHDRAWAL)) {
                        return false;
                    }

                    return true;
                })->action(function (Transaction $transaction) {
                    if ($transaction['type'] == Transaction::DEPOSIT) {
                        DepositController::rejectManualPayments($transaction->id);
                    } else {
                        WithdrawController::declineWithdrawal($transaction->id);
                    }
                }),
                Tables\Actions\EditAction::make(),
            ], position: ActionsPosition::BeforeColumns)
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
