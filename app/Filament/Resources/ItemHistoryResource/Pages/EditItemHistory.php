<?php

declare(strict_types=1);

namespace App\Filament\Resources\ItemHistoryResource\Pages;

use App\Filament\Resources\ItemHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditItemHistory extends EditRecord
{
    protected static string $resource = ItemHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
