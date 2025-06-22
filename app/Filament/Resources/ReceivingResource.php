<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceivingResource\Pages;
use App\Models\Receiving;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReceivingResource extends Resource
{
    protected static ?string $model = Receiving::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('receiving_number')
                    ->required()
                    ->default(function () {
                        $today = now()->format('Ymd');
                        $prefix = 'PNM'.$today;

                        $latest = Receiving::whereDate('created_at', now())
                            ->where('receiving_number', 'like', $prefix.'%')
                            ->latest('id')
                            ->first();

                        $lastNumber = $latest
                            ? (int) substr($latest->receiving_number, -3)
                            : 0;

                        return $prefix.str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
                    })
                    ->readonly(),
                Select::make('order_id')
                    ->relationship('order', 'order_number')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Ambil detail dari order terpilih
                        $order = \App\Models\Order::with('details.item')->find($state);

                        if (! $order) {
                            $set('details', []);

                            return;
                        }

                        $details = $order->details->map(function ($detail) {
                            return [
                                'item_id' => $detail->item_id,
                                'quantity' => $detail->quantity,
                            ];
                        })->toArray();

                        // Isi field details (Repeater)
                        $set('details', $details);
                    }),
                DatePicker::make('received_date')
                    ->default(now())
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(auth()->id())
                    ->disabled()
                    ->dehydrated(true)
                    ->required(),
                FileUpload::make('proof_file')
                    ->label('Upload Bukti Penerimaan')
                    ->directory('receiving-proofs')
                    ->preserveFilenames()
                    ->downloadable(),
                Textarea::make('note')
                    ->label('Catatan')
                    ->nullable(),
                TableRepeater::make('details')
                    ->label('Detail Barang')
                    ->headers([
                        Header::make('item'),
                        Header::make('quantity'),
                    ])
                    ->relationship()
                    ->schema([
                        Select::make('item_id')
                            ->label('Barang')
                            ->disabled()
                            ->dehydrated(true)
                            ->relationship('item', 'name'),

                        TextInput::make('quantity')
                            ->label('Jumlah Diterima')
                            ->numeric()
                            ->required(),
                    ])
                    ->default(function (callable $get) {
                        $order = \App\Models\Order::with('details.item')->find($get('order_id'));
                        if (! $order) {
                            return [];
                        }

                        return $order->details->map(function ($detail) {
                            return [
                                'item_id' => $detail->id,
                                'quantity' => $detail->quantity,
                            ];
                        })->toArray();
                    })
                    ->required()
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('receiving_number')->searchable(),
                Tables\Columns\TextColumn::make('order.order_number'),
                Tables\Columns\TextColumn::make('received_date')->date(),
                Tables\Columns\TextColumn::make('user.name'),
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
