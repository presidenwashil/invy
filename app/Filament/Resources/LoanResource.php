<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoanResource\Pages;
use App\Filament\Resources\LoanResource\RelationManagers;
use App\Models\Loan;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('warehouse_id')
                    ->label('Pemohon')
                    ->relationship('warehouse', 'name')
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
                            ->relationship('inventory', 'code')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->code} - {$record->item->name}")
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
                TextColumn::make('warehouse.name')->label('Pemohon'),
                TextColumn::make('loan_date')->date(),
                TextColumn::make('details_count')->counts('details')->label('Jumlah Barang'),
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
