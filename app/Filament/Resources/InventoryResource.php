<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Models\Inventory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('inventory_number')
                    ->required(),
                Forms\Components\Select::make('item_id')
                    ->required()
                    ->relationship('item', 'name')
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('warehouse_id')
                    ->required()
                    ->relationship('warehouse', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('serial_number')
                    ->nullable(),
                Forms\Components\TextInput::make('brand')
                    ->nullable(),
                Forms\Components\Textarea::make('specification')
                    ->nullable()
                    ->rows(3),
                Forms\Components\DatePicker::make('purchase_date')
                    ->nullable()
                    ->displayFormat('Y-m-d')
                    ->default(now())
                    ->native(false),
                Forms\Components\TextInput::make('production_year')
                    ->nullable()
                    ->numeric()
                    ->maxLength(4)
                    ->placeholder('e.g. 2023'),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'available' => 'Available',
                        'damaged' => 'Damaged',
                        'lost' => 'Lost',
                        'borrowed' => 'Borrowed',
                        'maintanance' => 'Maintanance',
                    ])
                    ->default('available')
                    ->preload()
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('inventory_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('item.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('specification')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('purchase_date')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }
}
