<?php

declare(strict_types=1);

namespace App\Filament\Resources\UnitResource\Pages;

use App\Filament\Resources\UnitResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateUnit extends CreateRecord
{
    protected static string $resource = UnitResource::class;
}
