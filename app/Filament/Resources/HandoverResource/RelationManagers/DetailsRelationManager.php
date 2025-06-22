<?php

namespace App\Filament\Resources\HandoverResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('inventory_id')
                    ->required()
                    ->relationship('inventory', 'inventory_number')
                    ->searchable()
                    ->preload(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('inventory.inventory_number')
                    ->label(__('Inventory Number'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inventory.item.name')
                    ->label(__('Item Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inventory.specification')
                    ->label(__('Specification'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inventory.purchase_date')
                    ->label(__('Purchase Date'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('inventory.production_year')
                    ->label(__('Production Year'))
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
