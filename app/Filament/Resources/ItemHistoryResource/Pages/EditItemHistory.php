<?php

namespace App\Filament\Resources\ItemHistoryResource\Pages;

use App\Filament\Resources\ItemHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemHistory extends EditRecord
{
    protected static string $resource = ItemHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
