<?php

declare(strict_types=1);

namespace App\Filament\Resources\HandoverResource\Pages;

use App\Filament\Resources\HandoverResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateHandover extends CreateRecord
{
    protected static string $resource = HandoverResource::class;
}
