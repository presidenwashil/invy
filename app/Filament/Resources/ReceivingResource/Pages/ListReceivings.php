<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReceivingResource\Pages;

use App\Filament\Resources\ReceivingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListReceivings extends ListRecords
{
    protected static string $resource = ReceivingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
