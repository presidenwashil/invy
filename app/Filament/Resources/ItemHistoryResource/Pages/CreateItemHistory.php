<?php

declare(strict_types=1);

namespace App\Filament\Resources\ItemHistoryResource\Pages;

use App\Filament\Resources\ItemHistoryResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateItemHistory extends CreateRecord
{
    protected static string $resource = ItemHistoryResource::class;
}
