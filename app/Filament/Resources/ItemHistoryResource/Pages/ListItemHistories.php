<?php

namespace App\Filament\Resources\ItemHistoryResource\Pages;

use App\Filament\Resources\ItemHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItemHistories extends ListRecords
{
    protected static string $resource = ItemHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
