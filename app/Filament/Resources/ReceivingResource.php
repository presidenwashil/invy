<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ReceivingResource\Pages;
use App\Models\Receiving;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class ReceivingResource extends Resource
{
    protected static ?string $model = Receiving::class;

    protected static ?int $navigationSort = 0;

    public static function getNavigationGroup(): string
    {
        return __('Transactions');
    }

    public static function getModelLabel(): string
    {
        return __('Receiving');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Receivings');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('receiving_number')
                    ->translateLabel()
                    ->required()
                    ->default(function () {
                        $today = now()->format('Ymd');
                        $prefix = 'PNM'.$today;

                        $latest = Receiving::whereDate('created_at', now())
                            ->where('receiving_number', 'like', $prefix.'%')
                            ->latest('id')
                            ->first();

                        $lastNumber = $latest
                            ? (int) mb_substr($latest->receiving_number, -3)
                            : 0;

                        return $prefix.mb_str_pad((string) ($lastNumber + 1), 3, '0', STR_PAD_LEFT);
                    })
                    ->readonly(),
                DatePicker::make('received_date')
                    ->translateLabel()
                    ->default(now())
                    ->required(),
                Select::make('staff_id')
                    ->translateLabel()
                    ->label(__('Received by'))
                    ->relationship('staff', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                FileUpload::make('proof_file')
                    ->translateLabel()
                    ->directory('receiving-proofs')
                    ->preserveFilenames()
                    ->downloadable(),
                Textarea::make('note')
                    ->translateLabel()
                    ->nullable(),
                TableRepeater::make('details')
                    ->label(__('Receiving details'))
                    ->headers([
                        Header::make(__('Item')),
                        Header::make(__('Quantity')),
                    ])
                    ->relationship()
                    ->schema([
                        Select::make('item_id')
                            ->translateLabel()
                            ->relationship('item', 'name')
                            ->preload()
                            ->searchable(),

                        TextInput::make('quantity')
                            ->translateLabel()
                            ->label('Jumlah Diterima')
                            ->numeric()
                            ->required(),
                    ])
                    ->required()
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('receiving_number')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('received_date')
                    ->translateLabel()
                    ->date(),
                Tables\Columns\TextColumn::make('staff.name')
                    ->label(__('Received by'))
                    ->searchable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListReceivings::route('/'),
            'create' => Pages\CreateReceiving::route('/create'),
            'edit' => Pages\EditReceiving::route('/{record}/edit'),
        ];
    }
}
