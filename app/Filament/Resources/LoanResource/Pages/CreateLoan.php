<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLoan extends CreateRecord
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
