<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ItemHistoryResource\Pages;
use App\Models\ItemHistory;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class ItemHistoryResource extends Resource
{
    protected static ?string $model = ItemHistory::class;

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): string
    {
        return __('Transactions');
    }

    public static function getModelLabel(): string
    {
        return __('Item History');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Item Histories');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('item.name')
                    ->label(__('Item'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('staff.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('initial_stock')
                    ->translateLabel()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('in')
                    ->translateLabel()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('out')
                    ->translateLabel()
                    ->numeric()
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
            'index' => Pages\ListItemHistories::route('/'),
            // 'create' => Pages\CreateItemHistory::route('/create'),
            // 'edit' => Pages\EditItemHistory::route('/{record}/edit'),
        ];
    }
}
