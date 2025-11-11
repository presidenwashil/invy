<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Models\Inventory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return __('Transactions');
    }

    public static function getModelLabel(): string
    {
        return __('Inventory');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Inventories');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('inventory_number')
                    ->translateLabel()
                    ->required(),
                Forms\Components\Select::make('item_id')
                    ->label(__('Item'))
                    ->required()
                    ->relationship('item', 'name')
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('staff_id')
                    ->translateLabel()
                    ->label(__('Staff'))
                    ->required()
                    ->relationship('staff', 'name')
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('warehouse_id')
                    ->label(__('Warehouse'))
                    ->required()
                    ->relationship('warehouse', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('serial_number')
                    ->translateLabel()
                    ->nullable(),
                Forms\Components\TextInput::make('brand')
                    ->translateLabel()
                    ->nullable(),
                Forms\Components\Textarea::make('specification')
                    ->translateLabel()
                    ->nullable()
                    ->rows(3),
                Forms\Components\DatePicker::make('handover_date')
                    ->translateLabel()
                    ->nullable()
                    ->displayFormat('Y-m-d')
                    ->default(now())
                    ->native(false),
                Forms\Components\TextInput::make('production_year')
                    ->translateLabel()
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
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('item.name')
                    ->label(__('Item Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label(__('Warehouse'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('serial_number')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('specification')
                    ->translateLabel()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('handover_date')
                    ->translateLabel()
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
