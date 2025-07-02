<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\HandoverResource\Pages;
use App\Filament\Resources\HandoverResource\RelationManagers;
use App\Models\Handover;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class HandoverResource extends Resource
{
    protected static ?string $model = Handover::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('Handover');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Handovers');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('staff_id')
                    ->translateLabel()
                    ->required()
                    ->relationship('staff', 'name')
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('handover_number')
                    ->translateLabel()
                    ->required(),
                Forms\Components\DatePicker::make('handover_date')
                    ->translateLabel()
                    ->default(now())
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('staff.nip')
                    ->label(__('NIP'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('staff.name')
                    ->label(__('Staff Name'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('handover_number')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('handover_date')
                    ->translateLabel()
                    ->date()
                    ->sortable(),
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
            RelationManagers\DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHandovers::route('/'),
            'create' => Pages\CreateHandover::route('/create'),
            'edit' => Pages\EditHandover::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
