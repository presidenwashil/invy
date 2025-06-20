<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use App\Models\Item;
use App\Models\ItemHistory;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateInventory extends CreateRecord
{
    protected static string $resource = InventoryResource::class;

    protected function beforeCreate(): void
    {
        $item = Item::find($this->data['item_id']);

        if (!$item || $item->stock <= 0) {
            Notification::make()
                ->title('Insufficient stock')
                ->body('The item stock is insufficient to create this inventory.')
                ->warning()
                ->send();

            throw ValidationException::withMessages([
                'item_id' => 'The selected item does not have sufficient stock.',
            ]);
        }

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
