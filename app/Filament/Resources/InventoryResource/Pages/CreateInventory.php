<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use App\Models\Item;
use App\Models\ItemHistory;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInventory extends CreateRecord
{
    protected static string $resource = InventoryResource::class;

        protected function afterCreate(): void
    {
        $inventory = $this->record;
        $item = Item::find($inventory->item_id);

        ItemHistory::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'type' => 'usage', // atau 'inventory'
            'initial_stock' => $item->stock,
            'in' => 0,
            'out' => 1,
        ]);

        $item->decrement('stock', 1);
    }
}
