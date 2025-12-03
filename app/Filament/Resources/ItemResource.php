<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class ItemResource extends Resource
{
    private const CODE_PREFIX = 'BRG';

    private const CODE_NUMBER_LENGTH = 8;

    protected static ?string $model = Item::class;

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): string
    {
        return __('Masters');
    }

    public static function getModelLabel(): string
    {
        return __('Item');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Items');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->translateLabel()
                    ->required()
                    ->default(fn () => self::generateItemCode())
                    ->afterStateHydrated(function (Forms\Components\TextInput $component, ?string $state, Set $set) {
                        if (blank($state)) {
                            $set('code', self::generateItemCode());
                        }
                    }),
                Forms\Components\TextInput::make('name')
                    ->translateLabel()
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->translateLabel()
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\TextInput::make('stock')
                    ->translateLabel()
                    ->required()
                    ->numeric()
                    ->readOnly()
                    ->default(0),
                Forms\Components\Toggle::make('status')
                    ->required(),
                Forms\Components\Select::make('unit_id')
                    ->translateLabel()
                    ->relationship('unit', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->translateLabel()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->translateLabel()
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('unit.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    protected static function generateItemCode(): string
    {
        $lastItem = Item::withTrashed()->orderByDesc('id')->first();
        $prefixLength = mb_strlen(self::CODE_PREFIX);
        $nextNumber = $lastItem ? ((int) mb_substr($lastItem->code, $prefixLength)) + 1 : 1;

        return self::CODE_PREFIX.mb_str_pad((string) $nextNumber, self::CODE_NUMBER_LENGTH, '0', STR_PAD_LEFT);
    }
}
