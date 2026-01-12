<?php

declare(strict_types=1);

namespace App\Filament\Resources\WithdrawalResource\Pages;

use App\Filament\Resources\WithdrawalResource;
use App\Models\ItemHistory;

/**
 * @extends \App\Filament\Pages\BaseCreateRecord<\App\Models\Withdrawal>
 */
final class CreateWithdrawal extends \App\Filament\Pages\BaseCreateRecord
{
    protected static string $resource = WithdrawalResource::class;

    protected function afterCreate(): void
    {
        foreach ($this->record->details as $detail) {
            $item = $detail->item;

            $initialStock = $item->stock;

            $item->decrement('stock', $detail->quantity);

            ItemHistory::create([
                'item_id' => $item->id,
                'staff_id' => $this->record->staff_id,
                'type' => 'withdrawal',
                'initial_stock' => $initialStock,
                'in' => 0,
                'out' => $detail->quantity,
            ]);
        }
    }
}
