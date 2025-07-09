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
use Illuminate\Support\Carbon;

final class HandoverResource extends Resource
{
    protected static ?string $model = Handover::class;

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('Transactions');
    }

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
                    ->label(__('Handed over to'))
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
                Forms\Components\FileUpload::make('proof_file')
                    ->translateLabel()
                    ->directory('receiving-proofs')
                    ->preserveFilenames()
                    ->downloadable(),
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
                    ->label(__('Handed over to'))
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
                Tables\Filters\Filter::make('year')
                    ->form([
                        Forms\Components\TextInput::make('year')
                            ->translateLabel()
                            ->numeric(),
                    ])
                    ->query(function ($query, array $data) {
                        if (! empty($data['year'])) {
                            $query->whereYear('handover_date', $data['year']);
                        }

                        return $query;
                    })
                    ->indicateUsing(function (array $data): ?string {
                        return ! empty($data['year']) ? __('Year').': '.$data['year'] : null;
                    }),
                Tables\Filters\SelectFilter::make('month')
                    ->translateLabel()
                    ->options(
                        collect(range(1, 12))->mapWithKeys(fn ($month) => [
                            $month => Carbon::create()->month($month)->translatedFormat('F'),
                        ])->toArray()
                    )
                    ->query(function (Builder $query, array $data) {
                        if (! empty($data['value'])) {
                            $query->whereMonth('handover_date', $data['value']);
                        }

                        return $query;
                    })
                    ->native(false),
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
