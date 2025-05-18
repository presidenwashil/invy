<?php

namespace App\Filament\Resources\WithdrawalResource\Pages;

use App\Filament\Resources\WithdrawalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWithdrawal extends CreateRecord
{
    protected static string $resource = WithdrawalResource::class;

    protected function afterCreate(): void
    {
        foreach ($this->record->details as $detail) {

            // Simpan ke item_histories juga jika diperlukan
            \App\Models\ItemHistory::create([
                'item_id' => $detail->item_id,
                'user_id' => auth()->id(),
                'type' => 'usage',
                'initial_stock' => $detail->item->stock,
                'in' => 0,
                'out' => $detail->quantity,
            ]);

            $detail->item->decrement('stock', $detail->quantity);
        }
    }

}
