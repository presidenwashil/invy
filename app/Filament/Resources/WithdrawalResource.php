<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawalResource\Pages;
use App\Models\Withdrawal;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class WithdrawalResource extends Resource
{
    protected static ?string $model = Withdrawal::class;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return __('Transactions');
    }

    public static function getModelLabel(): string
    {
        return __('Withdrawal');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Withdrawals');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('withdrawal_number')
                    ->translateLabel()
                    ->required()
                    ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord),
                DatePicker::make('withdrawal_date')
                    ->translateLabel()
                    ->default(now())
                    ->required()
                    ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord),
                Select::make('staff_id')
                    ->translateLabel()
                    ->label(__('Withdrawn by'))
                    ->relationship('staff', 'name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord),
                FileUpload::make('proof_file')
                    ->translateLabel()
                    ->disk('r2')
                    ->visibility('public')
                    ->downloadable(),
                Textarea::make('note')
                    ->translateLabel()
                    ->nullable(),
                TableRepeater::make('details')
                    ->label(__('Withdrawal Details'))
                    ->headers([
                        Header::make(__('Item')),
                        Header::make(__('Quantity')),
                    ])
                    ->relationship()
                    ->schema([
                        Select::make('item_id')
                            ->translateLabel()
                            ->relationship('item', 'name')
                            ->preload()
                            ->searchable()
                            ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord),

                        TextInput::make('quantity')
                            ->translateLabel()
                            ->label('Jumlah Dikeluarkan')
                            ->numeric()
                            ->required()
                            ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord),
                    ])
                    ->required()
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('withdrawal_date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('withdrawal_number')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('withdrawal_date')
                    ->translateLabel()
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('staff.name')
                    ->label(__('Withdrawn by'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-text')
                    ->url(fn ($record) => route('withdrawal.pdf', $record->id))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListWithdrawals::route('/'),
            'create' => Pages\CreateWithdrawal::route('/create'),
            'edit' => Pages\EditWithdrawal::route('/{record}/edit'),
        ];
    }
}
