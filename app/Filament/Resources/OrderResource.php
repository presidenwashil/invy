<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_number')
                    ->required()
                    ->default(function () {
                        $today = now()->format('Ymd');
                        $prefix = 'SPM' . $today;

                        $latest = Order::whereDate('created_at', now())
                            ->where('order_number', 'like', $prefix . '%')
                            ->latest('id')
                            ->first();

                        $lastNumber = $latest
                            ? (int) substr($latest->order_number, -3)
                            : 0;

                        return $prefix . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
                    })
                    ->readonly(),
                Forms\Components\Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(auth()->id())
                    ->disabled()
                    ->dehydrated(true)
                    ->required(),
                Forms\Components\DatePicker::make('order_date')
                    ->required()
                    ->default(now())
                    ->native(false),
                Forms\Components\TextInput::make('total_price')
                    ->readonly()
                    ->numeric()
                    ->dehydrated()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'canceled' => 'Canceled',
                        'completed' => 'Completed',
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                    ])
                    ->default('pending')
                    ->native(false)
                    ->required(),
                TableRepeater::make('details')
                    ->headers([
                        Header::make('name'),
                        Header::make('unit'),
                        Header::make('quantity'),
                        Header::make('price'),
                        Header::make('total_price'),
                    ])
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('item_id')
                            ->relationship('item', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $item = \App\Models\Item::find($state);
                                if ($item) {
                                    $set('price', $item->price);
                                    $set('unit_id', $item->unit_id);
                                }
                            }),
                        Forms\Components\Select::make('unit_id')
                            ->relationship('unit', 'name')
                            ->required()
                            ->disabled() 
                            ->dehydrated(true)
                            ->preload(),
                        Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $set('total_price', $get('price') * $state);
                            }),
                        Forms\Components\TextInput::make('price')
                            ->readonly()
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('total_price')
                            ->readonly()
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->afterStateHydrated(function ($state, callable $set, $get) {
                                $set('total_price', $get('price') * $get('quantity'));
                            })
                            ->dehydrated(true)

                    ])
                    ->columnSpan('full')
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('total_price', collect($state)->sum('total_price') ?? 0);
                    }),
                Forms\Components\FileUpload::make('upload'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
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
                // Tables\Actions\Action::make('generate_pdf')
                //     ->label('Generate PDF')
                //     ->url(fn (Order $record) => route('orders.pdf', ['orderId' => $record->id]))
                //     ->icon('heroicon-o-document-text'),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
