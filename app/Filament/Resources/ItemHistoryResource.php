<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemHistoryResource\Pages;
use App\Filament\Resources\ItemHistoryResource\RelationManagers;
use App\Models\ItemHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemHistoryResource extends Resource
{
    protected static ?string $model = ItemHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('item_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('type')
                    ->required(),
                Forms\Components\TextInput::make('initial_stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('in')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('out')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('item.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('initial_stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('in')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('out')
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
            'create' => Pages\CreateItemHistory::route('/create'),
            'edit' => Pages\EditItemHistory::route('/{record}/edit'),
        ];
    }
}
