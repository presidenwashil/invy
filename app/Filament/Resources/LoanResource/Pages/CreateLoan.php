<?php

declare(strict_types=1);

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateLoan extends CreateRecord
{
    protected static string $resource = LoanResource::class;

    public function afterCreate()
    {
        foreach ($this->record->details as $detail) {
            $detail->inventory->update([
                'status' => 'borrowed',
            ]);
        }
    }
}
