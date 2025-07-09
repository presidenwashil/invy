<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\LoanResource\Pages;
use App\Models\Loan;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): string
    {
        return __('Transactions');
    }

    public static function getModelLabel(): string
    {
        return __('Loan');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Loans');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('warehouse_id')
                    ->translateLabel()
                    ->relationship('warehouse', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),

                DatePicker::make('loan_date')
                    ->label('Tanggal Peminjaman')
                    ->default(now())
                    ->required(),

                Textarea::make('note')
                    ->label('Catatan')
                    ->columnSpan('full'),

                TableRepeater::make('details')
                    ->label('Detail Peminjaman')
                    ->headers([
                        Header::make('inventory_id')->label('Inventaris'),
                        Header::make('loan_status')->label('Status'),
                    ])
                    ->relationship()
                    ->schema([
                        Select::make('inventory_id')
                            ->label('Inventaris')
                            ->searchable()
                            ->preload()
                            ->relationship('inventory', 'inventory_number')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->inventory_number} - {$record->item->name}")
                            ->required(),

                        Select::make('loan_status')
                            ->label('Status')
                            ->options([
                                'loaned' => 'Dipinjam',
                                'returned' => 'Dikembalikan',
                            ])
                            ->default('loaned')
                            ->required(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('warehouse.name')
                    ->translateLabel(),
                TextColumn::make('loan_date')
                    ->translateLabel()
                    ->date(),
                TextColumn::make('details_count')
                    ->translateLabel()
                    ->counts('details'),
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
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }
}
