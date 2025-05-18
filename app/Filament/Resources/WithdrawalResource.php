<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawalResource\Pages;
use App\Filament\Resources\WithdrawalResource\RelationManagers;
use App\Models\Withdrawal;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WithdrawalResource extends Resource
{
    protected static ?string $model = Withdrawal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('withdrawal_number')
                    ->default(fn () => 'WDL' . now()->format('Ymd') . str_pad((Withdrawal::count() + 1), 3, '0', STR_PAD_LEFT))
                    ->readonly()
                    ->required(),
                Forms\Components\Select::make('warehouse_id')
                    ->label('Unit/Divisi')
                    ->relationship('warehouse', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\DatePicker::make('withdrawal_date')
                    ->required()
                    ->default(now()),
                Forms\Components\Textarea::make('note')
                    ->label('Catatan'),
                TableRepeater::make('details')
                    ->label('Detail Pengambilan')
                    ->headers([
                        Header::make('item_id')->label('Nama Barang'),
                        Header::make('quantity')->label('Jumlah'),
                    ])
                    ->relationship()
                    ->schema([
                        Select::make('item_id')
                            ->relationship('item', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->minValue(1),
                    ])
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('withdrawal_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Unit/Divisi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('withdrawal_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('proof_file')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListWithdrawals::route('/'),
            'create' => Pages\CreateWithdrawal::route('/create'),
            'edit' => Pages\EditWithdrawal::route('/{record}/edit'),
        ];
    }
}
