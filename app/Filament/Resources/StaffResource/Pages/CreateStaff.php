<?php

declare(strict_types=1);

namespace App\Filament\Resources\StaffResource\Pages;

use App\Filament\Resources\StaffResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateStaff extends CreateRecord
{
    protected static string $resource = StaffResource::class;
}
