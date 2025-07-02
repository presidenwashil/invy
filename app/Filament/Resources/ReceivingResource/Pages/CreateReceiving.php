<?php

namespace App\Filament\Resources\ReceivingResource\Pages;

use App\Filament\Resources\ReceivingResource;
use App\Models\ItemHistory;
use Filament\Resources\Pages\CreateRecord;

class CreateReceiving extends CreateRecord
{
    protected static string $resource = ReceivingResource::class;

    protected function afterCreate(): void
    {
        foreach ($this->record->details as $detail) {
            $item = $detail->item;

            $initialStock = $item->stock;

            $item->increment('stock', $detail->quantity);

            ItemHistory::create([
                'item_id' => $item->id,
                'staff_id' => $this->record->staff_id,
                'type' => 'receiving',
                'initial_stock' => $initialStock,
                'in' => $detail->quantity,
                'out' => 0,
            ]);
        }
    }
}
